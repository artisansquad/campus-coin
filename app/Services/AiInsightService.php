<?php

namespace App\Services;

use App\Models\Insight;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AiInsightService
{
    /**
     * Generate or regenerate AI spending insights for a student for a specific month.
     */
    public function generateMonthlyInsight(User $user, ?string $month = null): Insight
    {
        $currentMonth = $month ?: Carbon::now()->format('Y-m');
        $currentDate = Carbon::parse($currentMonth.'-01');
        $priorMonth = $currentDate->copy()->subMonth()->format('Y-m');

        $currentStart = $currentDate->copy()->startOfMonth()->toDateString();
        $currentEnd = $currentDate->copy()->endOfMonth()->toDateString();

        $priorStart = Carbon::parse($priorMonth.'-01')->startOfMonth()->toDateString();
        $priorEnd = Carbon::parse($priorMonth.'-01')->endOfMonth()->toDateString();

        // 1. Current month expenses grouped by category
        $currentExpenses = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$currentStart, $currentEnd])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(transactions.amount) as total_spent'), DB::raw('COUNT(transactions.id) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_spent')
            ->get();

        // 2. Prior month expenses grouped by category
        $priorExpenses = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$priorStart, $priorEnd])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(transactions.amount) as total_spent'))
            ->groupBy('categories.id', 'categories.name')
            ->pluck('total_spent', 'category_name')
            ->toArray();

        // 3. Total income and expense
        $totalIncome = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$currentStart, $currentEnd])
            ->sum('amount');

        $totalExpense = (float) $currentExpenses->sum('total_spent');
        $netSavings = $totalIncome - $totalExpense;
        $currency = $user->currencySymbol();

        // Find fastest growing category compared to last month
        $flaggedCategory = null;
        $maxGrowthPercentage = 0;

        foreach ($currentExpenses as $curr) {
            $catName = $curr->category_name;
            $currAmount = (float) $curr->total_spent;
            $prevAmount = isset($priorExpenses[$catName]) ? (float) $priorExpenses[$catName] : 0;

            if ($prevAmount > 0) {
                $growth = (($currAmount - $prevAmount) / $prevAmount) * 100;
                if ($growth > 15 && $growth > $maxGrowthPercentage) {
                    $maxGrowthPercentage = round($growth, 1);
                    $flaggedCategory = $catName;
                }
            } elseif ($currAmount > ($totalExpense * 0.25)) {
                // New high spend category
                $flaggedCategory = $catName;
                $maxGrowthPercentage = 100.0;
            }
        }

        // If no prior month growth found, pick the top spending category
        if (! $flaggedCategory && $currentExpenses->isNotEmpty()) {
            $flaggedCategory = $currentExpenses->first()->category_name;
            $maxGrowthPercentage = round(($currentExpenses->first()->total_spent / max(1, $totalExpense)) * 100, 1);
        }

        // Generate narrative summary
        $monthName = $currentDate->format('F Y');
        $topCat = $currentExpenses->first();

        if ($currentExpenses->isEmpty() && $totalIncome == 0) {
            $summary = "You haven't logged any transactions yet for {$monthName}. Start adding your income and expenses to unlock personalized spending intelligence!";
            $tip = 'Tip: Log your daily canteen purchases or hostel bills right away to keep your balance accurate.';
        } else {
            $summary = "In {$monthName}, you recorded {$currency}".number_format($totalIncome, 2)." in income and spent {$currency}".number_format($totalExpense, 2).'. ';

            if ($netSavings > 0) {
                $summary .= "Great job! You retained a positive net balance of {$currency}".number_format($netSavings, 2).' this month. ';
            } else {
                $summary .= "Your expenditures exceeded your monthly income by {$currency}".number_format(abs($netSavings), 2).'. ';
            }

            if ($topCat) {
                $summary .= "Your largest expenditure went toward {$topCat->category_name} ({$currency}".number_format($topCat->total_spent, 2).', comprising '.round(($topCat->total_spent / max(1, $totalExpense)) * 100).'% of your total outflow). ';
            }

            if ($flaggedCategory && $maxGrowthPercentage > 0) {
                $summary .= "Notably, {$flaggedCategory} showed a sharp spike of {$maxGrowthPercentage}% compared to previous spending cycles.";
            }

            // Generate Actionable Advice
            $tip = $this->generateActionableTip($flaggedCategory, $topCat?->total_spent ?? 0, $user);
        }

        // Save or update insight record
        $insight = Insight::updateOrCreate(
            [
                'user_id' => $user->id,
                'month' => $currentMonth,
            ],
            [
                'summary_text' => $summary,
                'flagged_category' => $flaggedCategory,
                'growth_percentage' => $maxGrowthPercentage ?: null,
                'tip_text' => $tip,
                'generated_at' => Carbon::now(),
            ]
        );

        return $insight;
    }

    /**
     * Generate actionable advice based on spending patterns.
     */
    protected function generateActionableTip(?string $category, float $amount, User $user): string
    {
        $currency = $user->currencySymbol();

        return match ($category) {
            'Food' => "Actionable Tip: Food spending spiked recently. Setting a weekly cap of {$currency}".number_format($amount / 4 * 0.8, 0)." or packing snacks from the hostel mess 2 days a week could save you around {$currency}".number_format($amount * 0.2, 0).' each month.',
            'Transport' => 'Actionable Tip: Commuting costs are on the rise. Check if your university offers student transit passes or coordinate carpools/van sharing with hostel mates to trim transport costs by 25%.',
            'Subscriptions' => 'Actionable Tip: Review your recurring active streaming and software subscriptions. Consider sharing a family plan or pausing unused services during final exams.',
            'Academics' => 'Actionable Tip: Before buying new semester textbooks, check student book swaps, the campus library digital reserves, or buy second-hand from senior batches.',
            'Entertainment' => 'Actionable Tip: Entertainment costs rose. Look out for campus-discounted student tickets or movie matinee discounts to enjoy outings without breaking your budget.',
            'Hostel/Rent' => 'Actionable Tip: Split utility or bulk grocery costs in your apartment/hostel directly at the start of each month to avoid late-cycle deficits.',
            default => "Actionable Tip: Target a 10% reduction in {$category} next month. Transferring {$currency}".number_format(max(500, $amount * 0.1), 0).' straight to your savings upon receiving your monthly allowance will help you build your reserve.',
        };
    }

    /**
     * Anomaly detection: checks if a transaction is unusually large or a duplicate.
     */
    public function detectAnomaly(User $user, float $amount, string $description, string $date, int $categoryId): array
    {
        $flagged = false;
        $reason = null;

        // 1. Duplicate check (same amount, category, within 24 hours)
        $duplicate = Transaction::where('user_id', $user->id)
            ->where('category_id', $categoryId)
            ->where('amount', $amount)
            ->whereBetween('date', [
                Carbon::parse($date)->subDay()->toDateString(),
                Carbon::parse($date)->addDay()->toDateString(),
            ])
            ->exists();

        if ($duplicate) {
            $flagged = true;
            $reason = 'Potential duplicate transaction detected within 24 hours.';
        }

        // 2. Unusually large check (e.g. > 3x average student expense)
        $avgExpense = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->avg('amount');

        if ($avgExpense > 0 && $amount >= ($avgExpense * 3.5) && $amount > 1000) {
            $flagged = true;
            $reason = 'Unusually large expense flagged (3.5x higher than your average purchase).';
        }

        return [
            'is_flagged' => $flagged,
            'flag_reason' => $reason,
        ];
    }

    /**
     * Forecast upcoming month spend based on historical trends (SRS Optional System Intelligence).
     */
    public function forecastNextMonth(User $user): array
    {
        $now = Carbon::now();
        $history = [];

        for ($i = 3; $i >= 1; $i--) {
            $m = $now->copy()->subMonths($i);
            $start = $m->copy()->startOfMonth()->toDateString();
            $end = $m->copy()->endOfMonth()->toDateString();

            $total = (float) Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereBetween('date', [$start, $end])
                ->sum('amount');

            $history[] = $total;
        }

        $avg = count($history) > 0 && array_sum($history) > 0 ? array_sum($history) / count($history) : (float) $user->monthly_allowance_baseline * 0.8;
        $projected = round($avg * 1.05, 2); // projected with 5% inflation/buffer

        return [
            'projected_spend' => $projected,
            'average_past_spend' => round($avg, 2),
            'recommended_daily_limit' => round($projected / 30, 2),
            'confidence_score' => count(array_filter($history)) >= 2 ? 'High' : 'Moderate',
        ];
    }
}
