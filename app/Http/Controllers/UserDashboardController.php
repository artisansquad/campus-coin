<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\UserDashboard;
use App\Services\AiInsightService;
use App\Services\SavingTipsEngine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function __construct(
        protected SavingTipsEngine $tipsEngine,
        protected AiInsightService $insightService
    ) {}

    public function index(Request $request): View
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $month = Carbon::now()->format('Y-m');
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $currentIncome = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $currentExpense = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $netBalance = $currentIncome - $currentExpense;
        $monthlyGoal = (float) ($user->monthly_savings_goal ?? 0);
        $savingRate = $monthlyGoal > 0 ? min(100, round(($netBalance / $monthlyGoal) * 100, 1)) : 0;

        $topCategory = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startOfMonth, $endOfMonth])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total_amount'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total_amount')
            ->first();

        $topCategoryPercentage = $topCategory && $currentExpense > 0
            ? round(($topCategory->total_amount / $currentExpense) * 100, 1)
            : 0;

        $budgetSummary = Budget::where('user_id', $user->id)
            ->where('month', $month)
            ->with('category')
            ->get();

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with(['category', 'aiSuggestedCategory'])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $categories = Category::forUser($user->id)->orderBy('name')->get();
        $unreadNotifications = $user->notifications()->where('is_read', false)->latest()->take(5)->get();

        $dashboardData = UserDashboard::updateOrCreate(
            [
                'user_id' => $user->id,
                'month' => $month,
            ],
            [
                'net_balance' => $netBalance,
                'monthly_income' => $currentIncome,
                'monthly_expense' => $currentExpense,
                'monthly_savings_goal' => $monthlyGoal,
                'saving_rate' => $savingRate,
                'top_category' => $topCategory->name ?? null,
                'top_category_percentage' => $topCategoryPercentage,
                'summary_json' => [
                    'month' => $month,
                    'budget_count' => $budgetSummary->count(),
                    'recent_transaction_count' => $recentTransactions->count(),
                    'last_updated' => Carbon::now()->toDateTimeString(),
                ],
                'last_updated_at' => Carbon::now(),
            ]
        );

        $hour = Carbon::now()->hour;
        $greeting = match (true) {
            $hour < 12 => 'Good morning',
            $hour < 17 => 'Good afternoon',
            default => 'Good evening',
        };

        $forecast = $this->insightService->forecastNextMonth($user);
        $savingTips = $this->tipsEngine->getTopTips($user, 3);

        return view('user.dashboard', compact(
            'user',
            'dashboardData',
            'greeting',
            'currentIncome',
            'currentExpense',
            'netBalance',
            'monthlyGoal',
            'savingRate',
            'topCategory',
            'topCategoryPercentage',
            'budgetSummary',
            'savingTips',
            'recentTransactions',
            'categories',
            'unreadNotifications',
            'forecast'
        ));
    }
}
