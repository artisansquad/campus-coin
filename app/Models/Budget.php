<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'month',
        'limit_amount',
    ];

    protected function casts(): array
    {
        return [
            'limit_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getSpentAmountAttribute(): float
    {
        $start = Carbon::parse($this->month.'-01')->startOfMonth()->toDateString();
        $end = Carbon::parse($this->month.'-01')->endOfMonth()->toDateString();

        return (float) Transaction::where('user_id', $this->user_id)
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereBetween('date', [$start, $end])
            ->sum('amount');
    }

    public function getPercentageAttribute(): float
    {
        if ($this->limit_amount <= 0) {
            return 0;
        }

        return round(($this->spent_amount / $this->limit_amount) * 100, 1);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, (float) $this->limit_amount - $this->spent_amount);
    }

    public function getStatusAttribute(): string
    {
        $percent = $this->percentage;
        if ($percent >= 100) {
            return 'exceeded';
        }
        if ($percent >= 80) {
            return 'warning';
        }

        return 'safe';
    }
}
