<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Services\AiInsightService;
use App\Services\SavingTipsEngine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected SavingTipsEngine $tipsEngine,
        protected AiInsightService $insightService
    ) {}

    public function index(Request $request): View
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->format('Y-m');
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        // 1. Current Month Financial Totals
        $currentIncome = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $currentExpense = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $netBalance = $currentIncome - $currentExpense;

        // 2. Savings Goal Progress
        $monthlyGoal = (float) $user->monthly_savings_goal;
        $currentSavings = max(0, $netBalance);
        $goalProgress = $monthlyGoal > 0 ? min(100, round(($currentSavings / $monthlyGoal) * 100, 1)) : 0;

        // 3. This Month's Top Spending Category
        $topCategory = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startOfMonth, $endOfMonth])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total_amount'), DB::raw('COUNT(transactions.id) as tx_count'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total_amount')
            ->first();

        $topCategoryPercentage = ($topCategory && $currentExpense > 0)
            ? round(($topCategory->total_amount / $currentExpense) * 100, 1)
            : 0;

        // 4. Budget vs. Actual Widget (Top 4 Category Budgets)
        $budgets = Budget::where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->with('category')
            ->get();

        // 5. Recommended Saving Tips
        $savingTips = $this->tipsEngine->getTopTips($user, 3);

        // 6. Recent Transactions (latest 6)
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with(['category', 'aiSuggestedCategory'])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        // 7. Accessible Categories for Quick Add
        $categories = Category::forUser($user->id)->orderBy('name')->get();

        // 8. Unread Notifications
        $unreadNotifications = $user->notifications()->where('is_read', false)->latest()->take(5)->get();

        // 9. Personalized Time-based Greeting
        $hour = Carbon::now()->hour;
        $greeting = match (true) {
            $hour < 12 => 'Good morning',
            $hour < 17 => 'Good afternoon',
            default => 'Good evening',
        };

        // 10. Forecast next month (System Intelligence)
        $forecast = $this->insightService->forecastNextMonth($user);

        return view('user.dashboard', compact(
            'user',
            'greeting',
            'currentIncome',
            'currentExpense',
            'netBalance',
            'monthlyGoal',
            'currentSavings',
            'goalProgress',
            'topCategory',
            'topCategoryPercentage',
            'budgets',
            'savingTips',
            'recentTransactions',
            'categories',
            'unreadNotifications',
            'forecast'
        ));
    }
}
