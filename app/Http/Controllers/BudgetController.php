<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));

        $start = Carbon::parse($selectedMonth.'-01')->startOfMonth()->toDateString();
        $end = Carbon::parse($selectedMonth.'-01')->endOfMonth()->toDateString();

        // Get expense categories available to user
        $expenseCategories = Category::forUser($user->id)->expense()->orderBy('name')->get();

        // Get existing budgets for selected month
        $budgets = Budget::where('user_id', $user->id)
            ->where('month', $selectedMonth)
            ->with('category')
            ->get();

        // Total budgeted and total spent across budgeted categories
        $totalBudgetLimit = (float) $budgets->sum('limit_amount');
        $totalBudgetSpent = (float) $budgets->sum(fn ($b) => $b->spent_amount);
        $overallBudgetPercentage = $totalBudgetLimit > 0 ? round(($totalBudgetSpent / $totalBudgetLimit) * 100, 1) : 0;

        return view('user.budgets', compact(
            'user',
            'selectedMonth',
            'expenseCategories',
            'budgets',
            'totalBudgetLimit',
            'totalBudgetSpent',
            'overallBudgetPercentage'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'month' => ['required', 'string', 'regex:/^\d{4}-\d{2}$/'],
            'limit_amount' => ['required', 'numeric', 'min:1'],
        ]);

        $budget = Budget::updateOrCreate(
            [
                'user_id' => $user->id,
                'category_id' => $validated['category_id'],
                'month' => $validated['month'],
            ],
            [
                'limit_amount' => $validated['limit_amount'],
            ]
        );

        $categoryName = $budget->category->name ?? 'Category';

        return back()->with('success', "Budget limit of {$user->currencySymbol()}".number_format($budget->limit_amount, 2)." set for {$categoryName}!");
    }

    public function destroy(Budget $budget): RedirectResponse
    {
        $user = Auth::user();
        if ($budget->user_id !== $user->id) {
            abort(403);
        }

        $budget->delete();

        return back()->with('success', 'Budget cap removed.');
    }
}
