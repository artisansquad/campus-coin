<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));
        $monthDate = Carbon::parse($selectedMonth.'-01');
        $startOfMonth = $monthDate->copy()->startOfMonth()->toDateString();
        $endOfMonth = $monthDate->copy()->endOfMonth()->toDateString();

        // Optional Category filter
        $categoryId = $request->query('category_id');

        // 1. Monthly totals
        $monthlyIncome = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->sum('amount');

        $monthlyExpense = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->sum('amount');

        $netSavings = $monthlyIncome - $monthlyExpense;
        $savingsRate = $monthlyIncome > 0 ? round(($netSavings / $monthlyIncome) * 100, 1) : 0;

        // 2. Category-wise Spending Breakdown
        $categoryBreakdown = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startOfMonth, $endOfMonth])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total_amount'),
                DB::raw('COUNT(transactions.id) as count')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total_amount')
            ->get();

        // 3. 6-Month Income vs. Expense Trend
        $sixMonthsTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i);
            $mStart = $m->copy()->startOfMonth()->toDateString();
            $mEnd = $m->copy()->endOfMonth()->toDateString();

            $inc = (float) Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereBetween('date', [$mStart, $mEnd])
                ->sum('amount');

            $exp = (float) Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereBetween('date', [$mStart, $mEnd])
                ->sum('amount');

            $sixMonthsTrend[] = [
                'month_label' => $m->format('M Y'),
                'income' => $inc,
                'expense' => $exp,
                'savings' => $inc - $exp,
            ];
        }

        // 4. Daily Spending Summary for the month
        $dailySpending = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->select('date', DB::raw('SUM(amount) as daily_total'), DB::raw('COUNT(id) as tx_count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 5. Weekly Spending Breakdown
        $weeklySpending = [
            'Week 1 (1st - 7th)' => 0,
            'Week 2 (8th - 14th)' => 0,
            'Week 3 (15th - 21st)' => 0,
            'Week 4 (22nd - End)' => 0,
        ];

        foreach ($dailySpending as $daily) {
            $day = Carbon::parse($daily->date)->day;
            if ($day <= 7) {
                $weeklySpending['Week 1 (1st - 7th)'] += (float) $daily->daily_total;
            } elseif ($day <= 14) {
                $weeklySpending['Week 2 (8th - 14th)'] += (float) $daily->daily_total;
            } elseif ($day <= 21) {
                $weeklySpending['Week 3 (15th - 21st)'] += (float) $daily->daily_total;
            } else {
                $weeklySpending['Week 4 (22nd - End)'] += (float) $daily->daily_total;
            }
        }

        // Categories list for filter
        $categories = Category::forUser($user->id)->orderBy('name')->get();

        return view('user.reports', compact(
            'user',
            'selectedMonth',
            'monthlyIncome',
            'monthlyExpense',
            'netSavings',
            'savingsRate',
            'categoryBreakdown',
            'sixMonthsTrend',
            'dailySpending',
            'weeklySpending',
            'categories',
            'categoryId'
        ));
    }

    public function exportPdf(Request $request): View
    {
        $user = Auth::user();
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));
        $monthDate = Carbon::parse($selectedMonth.'-01');
        $startOfMonth = $monthDate->copy()->startOfMonth()->toDateString();
        $endOfMonth = $monthDate->copy()->endOfMonth()->toDateString();

        $monthlyIncome = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyExpense = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $transactions = Transaction::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->with('category')
            ->orderBy('date')
            ->get();

        $categoryBreakdown = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startOfMonth, $endOfMonth])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(transactions.amount) as total_amount'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return view('user.report-pdf', compact(
            'user',
            'selectedMonth',
            'monthlyIncome',
            'monthlyExpense',
            'transactions',
            'categoryBreakdown'
        ));
    }
}
