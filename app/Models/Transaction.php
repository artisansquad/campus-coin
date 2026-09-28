<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'amount',
        'date',
        'description',
        'is_recurring',
        'recurring_frequency',
        'ai_suggested_category_id',
        'notes',
        'is_flagged',
        'flag_reason',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'date' => 'date',
            'is_recurring' => 'boolean',
            'is_flagged' => 'boolean',
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

    public function aiSuggestedCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ai_suggested_category_id');
    }

    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('type', 'expense');
    }

    public function scopeForMonth(Builder $query, ?string $month = null): Builder
    {
        $targetMonth = $month ?: Carbon::now()->format('Y-m');
        $start = Carbon::parse($targetMonth.'-01')->startOfMonth();
        $end = Carbon::parse($targetMonth.'-01')->endOfMonth();

        return $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
    }
}
