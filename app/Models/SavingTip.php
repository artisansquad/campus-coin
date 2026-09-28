<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingTip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'impact_amount',
        'category',
        'is_pinned',
        'is_dismissed',
        'is_bookmarked',
    ];

    protected function casts(): array
    {
        return [
            'impact_amount' => 'decimal:2',
            'is_pinned' => 'boolean',
            'is_dismissed' => 'boolean',
            'is_bookmarked' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_dismissed', false);
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeBookmarked(Builder $query): Builder
    {
        return $query->where('is_bookmarked', true);
    }
}
