<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\GoalTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GoalController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $goals = Goal::where('user_id', $user->id)
            ->with(['transactions' => function ($q) {
                $q->latest('transaction_date')->latest('id')->take(5);
            }])
            ->latest()
            ->get();

        // High-level aggregates across all goals
        $totalTarget = (float) $goals->sum('target_amount');
        $totalSaved = (float) $goals->sum('current_amount');
        $overallProgress = $totalTarget > 0 ? min(100, round(($totalSaved / $totalTarget) * 100, 1)) : 0;

        $totalDeposited = (float) GoalTransaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->sum('amount');

        $totalWithdrawn = (float) GoalTransaction::where('user_id', $user->id)
            ->where('type', 'withdraw')
            ->sum('amount');

        // Recent goal transaction history
        $recentTransactions = GoalTransaction::where('user_id', $user->id)
            ->with('goal')
            ->latest('transaction_date')
            ->latest('id')
            ->take(10)
            ->get();

        // Monthly cashflow data
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $monthlyIncome = (float) Transaction::where('user_id', $user->id)
            ->income()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        $monthlyExpense = (float) Transaction::where('user_id', $user->id)
            ->expense()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        $monthlyNet = max(0, $monthlyIncome - $monthlyExpense);

        return view('User.goals', compact(
            'user',
            'goals',
            'totalTarget',
            'totalSaved',
            'overallProgress',
            'totalDeposited',
            'totalWithdrawn',
            'recentTransactions',
            'monthlyNet'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'duration_months' => ['required', 'integer', 'min:1', 'max:120'],
            'initial_deposit' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $initialDeposit = (float) ($validated['initial_deposit'] ?? 0);
        $durationMonths = (int) $validated['duration_months'];
        $targetDate = Carbon::now()->addMonths($durationMonths)->toDateString();

        $goal = Goal::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'category' => $validated['category'] ?? 'Academic',
            'target_amount' => $validated['target_amount'],
            'current_amount' => min((float) $validated['target_amount'], $initialDeposit),
            'duration_months' => $durationMonths,
            'target_date' => $targetDate,
            'notes' => $validated['notes'] ?? null,
            'status' => ($initialDeposit >= (float) $validated['target_amount']) ? 'completed' : 'in_progress',
        ]);

        if ($initialDeposit > 0) {
            GoalTransaction::create([
                'goal_id' => $goal->id,
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $initialDeposit,
                'notes' => 'Initial deposit on goal creation',
                'transaction_date' => Carbon::now()->toDateString(),
            ]);
        }

        return redirect()->route('goals.index')
            ->with('success', "Savings goal '{$goal->title}' created successfully!");
    }

    public function update(Request $request, Goal $goal): RedirectResponse
    {
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to goal.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'current_amount' => ['nullable', 'numeric', 'min:0'],
            'duration_months' => ['required', 'integer', 'min:1', 'max:120'],
            'status' => ['nullable', 'in:in_progress,completed'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $durationMonths = (int) $validated['duration_months'];
        $targetDate = Carbon::now()->addMonths($durationMonths)->toDateString();

        $currentAmount = isset($validated['current_amount']) ? (float) $validated['current_amount'] : (float) $goal->current_amount;
        $status = $validated['status'] ?? $goal->status;
        if ($currentAmount >= (float) $validated['target_amount']) {
            $status = 'completed';
        }

        $goal->update([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? $goal->category,
            'target_amount' => $validated['target_amount'],
            'current_amount' => $currentAmount,
            'duration_months' => $durationMonths,
            'target_date' => $targetDate,
            'status' => $status,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('goals.index')
            ->with('success', "Goal '{$goal->title}' updated successfully!");
    }

    public function destroy(Goal $goal): RedirectResponse
    {
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to goal.');
        }

        $title = $goal->title;
        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', "Goal '{$title}' and its associated records have been removed.");
    }

    public function deposit(Request $request, Goal $goal): RedirectResponse
    {
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to goal.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $amount = (float) $validated['amount'];
        $newCurrent = (float) $goal->current_amount + $amount;
        $status = $newCurrent >= (float) $goal->target_amount ? 'completed' : 'in_progress';

        $goal->update([
            'current_amount' => $newCurrent,
            'status' => $status,
        ]);

        GoalTransaction::create([
            'goal_id' => $goal->id,
            'user_id' => Auth::id(),
            'type' => 'deposit',
            'amount' => $amount,
            'notes' => $validated['notes'] ?: 'Personal savings deposit',
            'transaction_date' => Carbon::now()->toDateString(),
        ]);

        $symbol = Auth::user()->currencySymbol();
        return redirect()->route('goals.index')
            ->with('success', "Successfully deposited {$symbol}" . number_format($amount, 2) . " into '{$goal->title}'!");
    }

    public function withdraw(Request $request, Goal $goal): RedirectResponse
    {
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to goal.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:' . $goal->current_amount],
            'notes' => ['required', 'string', 'max:255'],
        ], [
            'notes.required' => 'Please provide an emergency reason for withdrawing your savings.',
            'amount.max' => 'You cannot withdraw more than the currently saved balance in this goal.',
        ]);

        $amount = (float) $validated['amount'];
        $newCurrent = max(0, (float) $goal->current_amount - $amount);
        $status = $newCurrent >= (float) $goal->target_amount ? 'completed' : 'in_progress';

        $goal->update([
            'current_amount' => $newCurrent,
            'status' => $status,
        ]);

        GoalTransaction::create([
            'goal_id' => $goal->id,
            'user_id' => Auth::id(),
            'type' => 'withdraw',
            'amount' => $amount,
            'notes' => $validated['notes'],
            'transaction_date' => Carbon::now()->toDateString(),
        ]);

        $symbol = Auth::user()->currencySymbol();
        return redirect()->route('goals.index')
            ->with('success', "Emergency withdrawal of {$symbol}" . number_format($amount, 2) . " processed from '{$goal->title}'.");
    }
}
