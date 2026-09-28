<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\InAppNotification;
use App\Models\Transaction;
use Carbon\Carbon;

class BudgetAlertService
{
    /**
     * Check category budget after an expense transaction is logged, and dispatch notifications if nearing or exceeded.
     */
    public function checkBudgetAlert(Transaction $transaction): ?InAppNotification
    {
        if ($transaction->type !== 'expense') {
            return null;
        }

        $month = Carbon::parse($transaction->date)->format('Y-m');
        $budget = Budget::where('user_id', $transaction->user_id)
            ->where('category_id', $transaction->category_id)
            ->where('month', $month)
            ->first();

        if (! $budget || $budget->limit_amount <= 0) {
            return null;
        }

        $spent = $budget->spent_amount;
        $limit = $budget->limit_amount;
        $pct = ($spent / $limit) * 100;
        $categoryName = $budget->category->name ?? 'Category';
        $user = $transaction->user;
        $currency = $user ? $user->currencySymbol() : 'Rs. ';

        if ($pct >= 100) {
            // Exceeded alert
            return InAppNotification::firstOrCreate([
                'user_id' => $transaction->user_id,
                'title' => "Budget Exceeded: {$categoryName}",
                'type' => 'budget_alert',
                'message' => "You have spent {$currency}".number_format($spent, 2)." on {$categoryName}, exceeding your set limit of {$currency}".number_format($limit, 2).' ('.round($pct, 1).'%).',
            ]);
        } elseif ($pct >= 80) {
            // Nearing alert
            return InAppNotification::firstOrCreate([
                'user_id' => $transaction->user_id,
                'title' => "Budget Warning: {$categoryName}",
                'type' => 'warning',
                'message' => 'You have consumed '.round($pct, 1)."% ({$currency}".number_format($spent, 2).") of your {$categoryName} budget ({$currency}".number_format($limit, 2).').',
            ]);
        }

        return null;
    }
}
