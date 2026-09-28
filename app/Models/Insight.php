<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'summary_text',
        'flagged_category',
        'growth_percentage',
        'tip_text',
        'is_bookmarked',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'is_bookmarked' => 'boolean',
            'growth_percentage' => 'decimal:2',
            'generated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
