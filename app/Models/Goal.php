<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'target_amount',
        'current_amount',
        'duration_months',
        'target_date',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_amount' => 'decimal:2',
            'current_amount' => 'decimal:2',
            'duration_months' => 'integer',
            'target_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(GoalTransaction::class)->latest('transaction_date')->latest('id');
    }

    public function monthlyTarget(): float
    {
        $months = max(1, (int) ($this->duration_months ?? 1));
        return round((float) $this->target_amount / $months, 2);
    }

    public function remainingAmount(): float
    {
        return max(0, (float) $this->target_amount - (float) $this->current_amount);
    }

    public function monthlyRemainingTarget(): float
    {
        $months = max(1, (int) ($this->duration_months ?? 1));
        return round($this->remainingAmount() / $months, 2);
    }

    public function progressPercentage(): float
    {
        $target = (float) $this->target_amount;
        if ($target <= 0) {
            return 0;
        }

        return min(100, round(((float) $this->current_amount / $target) * 100, 1));
    }

    public function totalDeposited(): float
    {
        return (float) $this->transactions()->where('type', 'deposit')->sum('amount');
    }

    public function totalWithdrawn(): float
    {
        return (float) $this->transactions()->where('type', 'withdraw')->sum('amount');
    }
}
