<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PlatformAnalytics extends Model
{
    protected $table = 'platform_analytics';

    protected $fillable = [
        'metric_key',
        'label',
        'group',
        'period',
        'value',
        'change',
        'unit',
        'suffix',
        'meta',
    ];

    protected $casts = [
        'value' => 'float',
        'change' => 'float',
        'meta' => 'array',
    ];

    public static function forPeriod(string $period = '12m'): array
    {
        $now = Carbon::now();

        $startDate = match ($period) {
            '30d' => $now->copy()->subDays(30)->toDateString(),
            '6m' => $now->copy()->subMonths(6)->toDateString(),
            default => $now->copy()->subMonths(12)->toDateString(),
        };

        $students = User::where('role', 'student');
        $activeStudents = (clone $students)->where('status', 'active');
        $transactionsQuery = Transaction::where('date', '>=', $startDate);

        $totalStudents = (int) $students->count();
        $activeStudentsCount = (int) $activeStudents->count();
        $transactionsCount = (int) $transactionsQuery->count();
        $incomeTotal = (float) $transactionsQuery->clone()->where('type', 'income')->sum('amount');
        $expenseTotal = (float) $transactionsQuery->clone()->where('type', 'expense')->sum('amount');
        $savingsTotal = max(0, $incomeTotal - $expenseTotal);

        $previousStart = match ($period) {
            '30d' => $now->copy()->subDays(60)->toDateString(),
            '6m' => $now->copy()->subMonths(12)->toDateString(),
            default => $now->copy()->subYears(2)->toDateString(),
        };

        $previousTransactions = Transaction::whereBetween('date', [$previousStart, $now->copy()->subDay()->toDateString()])->count();
        $growthRate = $totalStudents > 0 ? round(($activeStudentsCount / $totalStudents) * 100, 1) : 0;
        $retentionRate = $growthRate;
        $conversionRate = $transactionsCount > 0 ? round(($transactionsCount / max(1, $totalStudents)) * 100, 1) : 0;
        $changeRate = $previousTransactions > 0 ? round((($transactionsCount - $previousTransactions) / $previousTransactions) * 100, 1) : 0;

        return [
            'growth_rate' => [
                'label' => 'Growth Rate',
                'value' => $growthRate,
                'suffix' => '%',
                'change' => $changeRate,
                'description' => 'vs previous period',
            ],
            'savings' => [
                'label' => 'Savings',
                'value' => $savingsTotal,
                'prefix' => 'Rs. ',
                'suffix' => '',
                'change' => $changeRate,
                'description' => 'tracked transactions',
            ],
            'conversion' => [
                'label' => 'Conversion',
                'value' => $conversionRate,
                'suffix' => '%',
                'change' => $changeRate,
                'description' => 'user activity',
            ],
            'retention' => [
                'label' => 'Retention',
                'value' => $retentionRate,
                'suffix' => '%',
                'change' => $changeRate,
                'description' => 'active users',
            ],
            'transaction_activity' => [
                'label' => 'Transaction Activity',
                'value' => $transactionsCount,
                'suffix' => '',
                'change' => $changeRate,
                'description' => 'this period',
            ],
            'summary' => [
                'students' => $totalStudents,
                'active_students' => $activeStudentsCount,
                'transactions' => $transactionsCount,
                'income_total' => $incomeTotal,
                'expense_total' => $expenseTotal,
                'savings_total' => $savingsTotal,
                'period' => $period,
            ],
            'chart' => self::chartSeries($period),
        ];
    }

    public static function chartSeries(string $period = '12m'): array
    {
        $now = Carbon::now();
        $months = match ($period) {
            '30d' => 4,
            '6m' => 6,
            default => 6,
        };

        $series = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $start = $month->copy()->startOfMonth()->toDateString();
            $end = $month->copy()->endOfMonth()->toDateString();

            $series[] = [
                'label' => $month->translatedFormat('M'),
                'value' => (int) Transaction::whereBetween('date', [$start, $end])->count(),
            ];
        }

        return $series;
    }

    public static function refreshSnapshot(string $period = '12m'): array
    {
        $snapshot = self::forPeriod($period);

        foreach ($snapshot as $key => $value) {
            if ($key === 'chart' || $key === 'summary') {
                continue;
            }

            self::updateOrCreate(
                ['metric_key' => $key, 'period' => $period],
                [
                    'label' => $value['label'] ?? ucfirst(str_replace('_', ' ', $key)),
                    'group' => 'kpi',
                    'value' => (float) ($value['value'] ?? 0),
                    'change' => (float) ($value['change'] ?? 0),
                    'unit' => $value['prefix'] ?? '',
                    'suffix' => $value['suffix'] ?? '',
                    'meta' => $value,
                ]
            );
        }

        self::updateOrCreate(
            ['metric_key' => 'chart', 'period' => $period],
            [
                'label' => 'Savings Trends',
                'group' => 'chart',
                'value' => 0,
                'change' => 0,
                'unit' => '',
                'suffix' => '',
                'meta' => ['series' => $snapshot['chart']],
            ]
        );

        return $snapshot;
    }
}
