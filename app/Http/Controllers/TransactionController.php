<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Services\AiCategorizationService;
use App\Services\AiInsightService;
use App\Services\BudgetAlertService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
    public function __construct(
        protected AiCategorizationService $aiCategorizer,
        protected AiInsightService $insightService,
        protected BudgetAlertService $budgetAlertService
    ) {}

    public function index(Request $request): View
    {
        $user = Auth::user();
        $query = Transaction::where('user_id', $user->id)->with(['category', 'aiSuggestedCategory']);

        // Search filter (description)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($catQ) => $catQ->where('name', 'like', "%{$search}%"));
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Type filter (income / expense)
        if ($request->filled('type') && in_array($request->input('type'), ['income', 'expense'])) {
            $query->where('type', $request->input('type'));
        }

        // Date range filter
        if ($request->filled('date_filter')) {
            $now = Carbon::now();
            match ($request->input('date_filter')) {
                'this_month' => $query->whereBetween('date', [$now->copy()->startOfMonth()->toDateString(), $now->copy()->endOfMonth()->toDateString()]),
                'last_month' => $query->whereBetween('date', [$now->copy()->subMonth()->startOfMonth()->toDateString(), $now->copy()->subMonth()->endOfMonth()->toDateString()]),
                'last_30_days' => $query->where('date', '>=', $now->copy()->subDays(30)->toDateString()),
                'last_90_days' => $query->where('date', '>=', $now->copy()->subDays(90)->toDateString()),
                'this_year' => $query->whereBetween('date', [$now->copy()->startOfYear()->toDateString(), $now->copy()->endOfYear()->toDateString()]),
                default => null,
            };
        }

        $totalTransactionsCount = (clone $query)->count();
        $transactions = $query->orderByDesc('date')->orderByDesc('id')->paginate(15)->withQueryString();

        // Calculate summary cards for transactions view
        $totalIncome = (float) Transaction::where('user_id', $user->id)->income()->sum('amount');
        $totalExpense = (float) Transaction::where('user_id', $user->id)->expense()->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        $categories = Category::forUser($user->id)->orderBy('name')->get();

        return view('user.transactions', compact(
            'user',
            'transactions',
            'totalTransactionsCount',
            'totalIncome',
            'totalExpense',
            'netBalance',
            'categories'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'type' => ['required', 'in:income,expense'],
            'category_id' => ['required', 'exists:categories,id'],
            'date' => ['required', 'date'],
            'is_recurring' => ['nullable', 'boolean'],
            'recurring_frequency' => ['nullable', 'in:weekly,monthly,yearly'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // AI Category Suggestion
        $aiCategory = $this->aiCategorizer->suggest($validated['description'], $user->id);

        // Anomaly / Duplicate check
        $anomaly = $this->insightService->detectAnomaly(
            $user,
            (float) $validated['amount'],
            $validated['description'],
            $validated['date'],
            (int) $validated['category_id']
        );

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'category_id' => $validated['category_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'],
            'is_recurring' => $request->boolean('is_recurring'),
            'recurring_frequency' => $request->input('recurring_frequency'),
            'ai_suggested_category_id' => $aiCategory?->id,
            'notes' => $validated['notes'] ?? null,
            'is_flagged' => $anomaly['is_flagged'],
            'flag_reason' => $anomaly['flag_reason'],
        ]);

        // Learn AI association
        $this->aiCategorizer->learn($user->id, $validated['description'], (int) $validated['category_id']);

        // Check budget thresholds
        $this->budgetAlertService->checkBudgetAlert($transaction);

        $msg = 'Transaction successfully logged!';
        if ($anomaly['is_flagged']) {
            $msg .= ' Note: '.$anomaly['flag_reason'];
        }

        return back()->with('success', $msg);
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $user = Auth::user();
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'type' => ['required', 'in:income,expense'],
            'category_id' => ['required', 'exists:categories,id'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $previousCategoryId = $transaction->category_id;
        $transaction->update($validated);

        // Learn correction if category was adjusted by student!
        if ($previousCategoryId !== (int) $validated['category_id']) {
            $this->aiCategorizer->learn($user->id, $validated['description'], (int) $validated['category_id']);
        }

        $this->budgetAlertService->checkBudgetAlert($transaction);

        return back()->with('success', 'Transaction updated successfully!');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $user = Auth::user();
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        $transaction->delete(); // Soft delete retaining full audit history

        return back()->with('success', 'Transaction moved to trash (history retained).');
    }

    /**
     * Live AI Category Suggestion JSON API as student types.
     */
    public function suggestCategory(Request $request): JsonResponse
    {
        $description = (string) $request->query('description', '');
        $user = Auth::user();

        $suggested = $this->aiCategorizer->suggest($description, $user?->id);

        if ($suggested) {
            return response()->json([
                'success' => true,
                'category_id' => $suggested->id,
                'category_name' => $suggested->name,
                'category_type' => $suggested->type,
                'confidence' => 0.95,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No confident category match found yet.',
        ]);
    }

    /**
     * Bulk CSV Import of Historical Transactions.
     */
    public function importCsv(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ]);

        $user = Auth::user();
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        if (! $handle) {
            return back()->withErrors(['csv_file' => 'Failed to open the uploaded file.']);
        }

        $header = fgetcsv($handle);
        $importedCount = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (empty(array_filter($row))) {
                continue;
            }

            // Expected columns: Date, Description, Amount, Type (optional), Category (optional)
            $date = isset($row[0]) && ! empty($row[0]) ? Carbon::parse($row[0])->toDateString() : Carbon::now()->toDateString();
            $description = trim($row[1] ?? 'Imported Transaction');
            $amount = abs((float) preg_replace('/[^0-9.]/', '', $row[2] ?? '0'));
            $type = isset($row[3]) && strtolower(trim($row[3])) === 'income' ? 'income' : 'expense';
            $categoryName = trim($row[4] ?? '');

            if ($amount <= 0) {
                continue;
            }

            // Find category or let AI suggest
            $category = null;
            if (! empty($categoryName)) {
                $category = Category::forUser($user->id)->where('name', 'like', "%{$categoryName}%")->first();
            }

            if (! $category) {
                $category = $this->aiCategorizer->suggest($description, $user->id);
            }

            if (! $category) {
                $category = Category::forUser($user->id)->where('type', $type)->first();
            }

            Transaction::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'type' => $type,
                'amount' => $amount,
                'date' => $date,
                'description' => $description,
                'notes' => 'Imported via CSV',
            ]);

            $importedCount++;
        }

        fclose($handle);

        return back()->with('success', "Successfully imported {$importedCount} transactions from CSV!");
    }

    /**
     * Export Transactions to CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->orderByDesc('date')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="campus_coin_transactions_'.date('Y-m-d').'.csv"',
        ];

        return response()->stream(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Description', 'Type', 'Category', 'Amount', 'Recurring', 'Notes']);

            foreach ($transactions as $tx) {
                fputcsv($handle, [
                    $tx->date->format('Y-m-d'),
                    $tx->description,
                    ucfirst($tx->type),
                    $tx->category->name ?? 'Uncategorized',
                    $tx->amount,
                    $tx->is_recurring ? 'Yes' : 'No',
                    $tx->notes ?? '',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
