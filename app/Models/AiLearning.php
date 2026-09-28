<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiLearning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'keyword',
        'category_id',
        'confidence',
    ];

    protected function casts(): array
    {
        return [
            'confidence' => 'float',
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
}
