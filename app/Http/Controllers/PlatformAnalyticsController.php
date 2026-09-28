<?php

namespace App\Http\Controllers;

use App\Models\PlatformAnalytics;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlatformAnalyticsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $period = $request->query('period', '12m');

        $records = PlatformAnalytics::where('period', $period)->get();

        if ($records->isEmpty()) {
            $snapshot = PlatformAnalytics::refreshSnapshot($period);
            $records = PlatformAnalytics::where('period', $period)->get();
        } else {
            $snapshot = PlatformAnalytics::forPeriod($period);
        }

        $payload = [
            'stats' => [],
            'chart' => $snapshot['chart'] ?? [],
            'summary' => $snapshot['summary'] ?? [],
            'period' => $period,
            'generated_at' => now()->toISOString(),
        ];

        foreach (['growth_rate', 'savings', 'conversion', 'retention', 'transaction_activity'] as $metricKey) {
            $record = $records->firstWhere('metric_key', $metricKey);
            $metric = $snapshot[$metricKey] ?? null;

            $payload['stats'][] = [
                'key' => $metricKey,
                'label' => $metric['label'] ?? ($record?->label ?? ucfirst(str_replace('_', ' ', $metricKey))),
                'value' => $metric['value'] ?? (float) ($record?->value ?? 0),
                'prefix' => $metric['prefix'] ?? $record?->unit ?? '',
                'suffix' => $metric['suffix'] ?? $record?->suffix ?? '',
                'change' => $metric['change'] ?? (float) ($record?->change ?? 0),
                'description' => $metric['description'] ?? ($record?->meta['description'] ?? ''),
            ];
        }

        return response()->json($payload);
    }

    public function refresh(Request $request): JsonResponse
    {
        $period = $request->query('period', '12m');

        try {
            $snapshot = PlatformAnalytics::refreshSnapshot($period);

            return response()->json([
                'success' => true,
                'period' => $period,
                'data' => $snapshot,
            ]);
        } catch (\Throwable $e) {
            Log::error('Platform analytics refresh failed', ['exception' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to refresh analytics right now.',
            ], 500);
        }
    }
}
