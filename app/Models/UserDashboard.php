<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDashboard extends Model
{
    protected $fillable = [
        'user_id',
        'net_balance',
        'monthly_income',
        'monthly_expense',
        'monthly_savings_goal',
        'saving_rate',
        'top_category',
        'top_category_percentage',
        'summary_json',
        'last_updated_at',
    ];

    protected $casts = [
        'net_balance' => 'decimal:2',
        'monthly_income' => 'decimal:2',
        'monthly_expense' => 'decimal:2',
        'monthly_savings_goal' => 'decimal:2',
        'saving_rate' => 'decimal:2',
        'top_category_percentage' => 'decimal:2',
        'summary_json' => 'array',
        'last_updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
