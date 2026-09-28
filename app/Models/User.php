<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'student_id',
        'password',
        'role',
        'status',
        'age',
        'academic_year',
        'preferred_currency',
        'monthly_allowance_baseline',
        'monthly_savings_goal',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'age' => 'integer',
            'monthly_allowance_baseline' => 'decimal:2',
            'monthly_savings_goal' => 'decimal:2',
        ];
    }

    public function isAdmin(): bool
    {
        return in_array(strtolower((string) ($this->role ?? '')), ['admin', 'administrator'], true);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->name} {$this->last_name}");
    }

    public function currencySymbol(): string
    {
        return match (strtoupper($this->preferred_currency ?? 'PKR')) {
            'USD', '$' => '$',
            'EUR', '€' => '€',
            'GBP', '£' => '£',
            'INR', '₹' => '₹',
            'AED' => 'AED ',
            'SAR' => 'SAR ',
            default => 'Rs. ',
        };
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function customCategories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function insights(): HasMany
    {
        return $this->hasMany(Insight::class);
    }

    public function savingTips(): HasMany
    {
        return $this->hasMany(SavingTip::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(InAppNotification::class);
    }

    /**
     * Get all categories available for this student (default categories + own custom).
     */
    public function accessibleCategories()
    {
        return Category::where(function ($query) {
            $query->whereNull('user_id')
                ->orWhere('user_id', $this->id);
        });
    }

    public function userDashboards(): HasMany
    {
        return $this->hasMany(UserDashboard::class);
    }

    public function dashboard(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserDashboard::class)->latestOfMany();
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class)->latest();
    }

    public function goalTransactions(): HasMany
    {
        return $this->hasMany(GoalTransaction::class)->latest('transaction_date')->latest('id');
    }
}
