<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'user_id',
        'type',
        'amount',
        'notes',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'date',
        ];
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
