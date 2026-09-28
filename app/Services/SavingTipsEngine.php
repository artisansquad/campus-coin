<?php

namespace App\Services;

use App\Models\SavingTip;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class SavingTipsEngine
{
    /**
     * Generate dynamic personalized saving tips for a student based on live transaction data and budget performance.
     */
    public function generateTipsForUser(User $user): void
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $start = Carbon::now()->startOfMonth()->toDateString();
        $end = Carbon::now()->endOfMonth()->toDateString();

        // 1. Food spending check
        $foodSpent = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$start, $end])
            ->whereHas('category', fn ($q) => $q->where('name', 'Food'))
            ->sum('amount');

        if ($foodSpent > 2000) {
            $potential = round($foodSpent * 0.20, 2);
            SavingTip::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => 'Optimize Campus Dining & Snacks',
                ],
                [
                    'category' => 'Food',
                    'impact_amount' => $potential,
                    'description' => "You have spent {$user->currencySymbol()}".number_format($foodSpent, 2)." on food this month. By planning hostel mess meals and curbing late-night takeout orders twice a week, you could save approximately {$user->currencySymbol()}".number_format($potential, 2).'.',
                ]
            );
        }

        // 2. Subscriptions audit check
        $subscriptionSpent = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$start, $end])
            ->whereHas('category', fn ($q) => $q->where('name', 'Subscriptions'))
            ->sum('amount');

        if ($subscriptionSpent > 800) {
            $potential = round($subscriptionSpent * 0.40, 2);
            SavingTip::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => 'Audit Streaming & App Subscriptions',
                ],
                [
                    'category' => 'Subscriptions',
                    'impact_amount' => $potential,
                    'description' => "You are spending {$user->currencySymbol()}".number_format($subscriptionSpent, 2)." on monthly digital subscriptions. Switching to student plans (Spotify Student, Prime Student) or sharing family bundles can save you up to {$user->currencySymbol()}".number_format($potential, 2).'.',
                ]
            );
        }

        // 3. Transport efficiency
        $transportSpent = (float) Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$start, $end])
            ->whereHas('category', fn ($q) => $q->where('name', 'Transport'))
            ->sum('amount');

        if ($transportSpent > 1500) {
            $potential = round($transportSpent * 0.25, 2);
            SavingTip::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => 'Switch to Student Transit Passes & Carpools',
                ],
                [
                    'category' => 'Transport',
                    'impact_amount' => $potential,
                    'description' => "Commute expenses reached {$user->currencySymbol()}".number_format($transportSpent, 2).'. Inquire about monthly student metro/bus concession cards or organize ride-sharing with classmates.',
                ]
            );
        }

        // 4. Savings Goal Milestone
        if ($user->monthly_savings_goal > 0) {
            $income = (float) Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereBetween('date', [$start, $end])
                ->sum('amount');

            $expense = (float) Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereBetween('date', [$start, $end])
                ->sum('amount');

            $currentSavings = max(0, $income - $expense);
            $gap = $user->monthly_savings_goal - $currentSavings;

            if ($gap > 0) {
                SavingTip::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'title' => 'Close Your Monthly Savings Target Gap',
                    ],
                    [
                        'category' => 'Savings',
                        'impact_amount' => $gap,
                        'description' => "You are {$user->currencySymbol()}".number_format($gap, 2)." away from your monthly target of {$user->currencySymbol()}".number_format($user->monthly_savings_goal, 2).". Setting aside just {$user->currencySymbol()}".number_format($gap / max(1, 30 - Carbon::now()->day), 0).' daily will help you reach 100%!',
                    ]
                );
            }
        }
    }

    /**
     * Get top ranked saving tips for dashboard display.
     */
    public function getTopTips(User $user, int $limit = 4)
    {
        $this->generateTipsForUser($user);

        return SavingTip::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhereNull('user_id');
        })
            ->active()
            ->orderByDesc('is_pinned')
            ->orderByDesc('impact_amount')
            ->take($limit)
            ->get();
    }
}
