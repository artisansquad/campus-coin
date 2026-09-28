@extends('layouts.app')

@section('title', 'Monthly Financial Reports — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">Reports</span>
@endsection

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header with Export Actions (Requirement 21 & 33) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Monthly Financial Reports</h1>
            <p class="text-xs text-slate-400 mt-1">Multi-dimensional spending analytics: 6-month trends, weekly outflows, and category distribution.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Email Share (Requirement 33) -->
            <a href="mailto:?subject=Campus%20Coin%20Monthly%20Report%20({{ $selectedMonth }})&body=Check%20out%20my%20student%20monthly%20financial%20report%20from%20Campus%20Coin!%20Total%20Income:%20{{ $user->currencySymbol() }}{{ number_format($monthlyIncome,2) }}%20|%20Total%20Expense:%20{{ $user->currencySymbol() }}{{ number_format($monthlyExpense,2) }}%20|%20Net%20Savings:%20{{ $user->currencySymbol() }}{{ number_format($netSavings,2) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-700 hover:border-slate-600 bg-slate-800/40 text-slate-300 hover:text-white flex items-center gap-2 transition-all">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Share by Email</span>
            </a>

            <!-- Export PDF Link (Requirement 21 & 33) -->
            <a href="{{ route('reports.pdf', ['month' => $selectedMonth]) }}" target="_blank"
               class="px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30 flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export Report PDF</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar (Requirement 20) -->
    <div class="glass-panel p-4">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <label class="text-xs text-slate-400">Month:</label>
                <input type="month" name="month" value="{{ $selectedMonth }}" 
                       class="px-3 py-1.5 rounded-xl border bg-slate-900/60 border-slate-700 text-xs text-slate-200">
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs text-slate-400">Category Filter:</label>
                <select name="category_id" class="px-3 py-1.5 rounded-xl border bg-slate-900/60 border-slate-700 text-xs text-slate-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold">Update View</button>
            @if(request()->anyFilled(['category_id']))
                <a href="{{ route('reports.index', ['month' => $selectedMonth]) }}" class="text-xs text-slate-400 hover:underline">Clear Filter</a>
            @endif
        </form>
    </div>

    <!-- 3 Core Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="glass-panel p-4">
            <span class="text-xs text-slate-400 font-medium">Monthly Inflow</span>
            <p class="text-xl font-bold text-emerald-400 mt-1">{{ $user->currencySymbol() }}{{ number_format($monthlyIncome, 2) }}</p>
        </div>

        <div class="glass-panel p-4">
            <span class="text-xs text-slate-400 font-medium">Monthly Outflow</span>
            <p class="text-xl font-bold text-red-400 mt-1">{{ $user->currencySymbol() }}{{ number_format($monthlyExpense, 2) }}</p>
        </div>

        <div class="glass-panel p-4">
            <span class="text-xs text-slate-400 font-medium">Net Retained</span>
            <p class="text-xl font-bold {{ $netSavings >= 0 ? 'text-blue-400' : 'text-red-400' }} mt-1">
                {{ $user->currencySymbol() }}{{ number_format($netSavings, 2) }}
            </p>
        </div>

        <div class="glass-panel p-4">
            <span class="text-xs text-slate-400 font-medium">Savings Rate</span>
            <p class="text-xl font-bold {{ $savingsRate >= 20 ? 'text-emerald-400' : 'text-amber-400' }} mt-1">
                {{ $savingsRate }}%
            </p>
        </div>
    </div>

    <!-- Charts Row: 6-Month Trend & Category Distribution (Requirement 17 & 18) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 6-Month Income vs Expense Trend -->
        <div class="glass-panel p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">6-Month Inflow vs Outflow Trend</h3>
                <span class="text-[11px] text-slate-400">Past 6 Months</span>
            </div>
            <div class="h-64 relative">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Category Spending Distribution (Requirement 17) -->
        <div class="glass-panel p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">Category Spending Distribution</h3>
                <span class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($selectedMonth.'-01')->format('M Y') }}</span>
            </div>
            <div class="h-64 relative flex items-center justify-center">
                @if($categoryBreakdown->count() > 0)
                    <canvas id="categoryChart"></canvas>
                @else
                    <p class="text-xs text-slate-500">No expense records for this month to generate pie distribution.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Weekly & Daily Spending Summaries (Requirement 19) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Weekly Breakdown -->
        <div class="glass-panel p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">Weekly Spending Pace</h3>
                <span class="text-[11px] text-slate-400">4-Week Breakdown</span>
            </div>

            <div class="space-y-3">
                @foreach($weeklySpending as $weekName => $weekAmount)
                    @php
                        $weekPct = $monthlyExpense > 0 ? round(($weekAmount / $monthlyExpense) * 100, 1) : 0;
                    @endphp
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-300 font-medium">{{ $weekName }}</span>
                            <span class="font-mono text-slate-400">{{ $user->currencySymbol() }}{{ number_format($weekAmount, 2) }} ({{ $weekPct }}%)</span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                            <div class="h-full rounded-full bg-blue-500 transition-all duration-300" style="width: {{ $weekPct }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Category Spending Details Table -->
        <div class="glass-panel p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">Category Spending Details</h3>
                <span class="text-[11px] text-slate-400">{{ $categoryBreakdown->count() }} Categories Active</span>
            </div>

            <div class="max-h-60 overflow-y-auto space-y-2">
                @forelse($categoryBreakdown as $cb)
                    @php
                        $catPct = $monthlyExpense > 0 ? round(($cb->total_amount / $monthlyExpense) * 100, 1) : 0;
                    @endphp
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-900/40 border border-slate-800/80">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $cb->color ?? '#3B82F6' }};"></span>
                            <span class="text-xs font-semibold text-slate-200">{{ $cb->name }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">({{ $cb->count }} tx)</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold font-mono text-white">{{ $user->currencySymbol() }}{{ number_format($cb->total_amount, 2) }}</span>
                            <span class="text-[10px] text-blue-400 ml-1.5">({{ $catPct }}%)</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-8">No categories logged for this time period.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Six Months Trend Bar/Line Chart
        const trendData = @js($sixMonthsTrend);
        const labels = trendData.map(d => d.month_label);
        const incomeData = trendData.map(d => d.income);
        const expenseData = trendData.map(d => d.expense);

        const ctxTrend = document.getElementById('trendChart');
        if (ctxTrend) {
            new Chart(ctxTrend, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Income Inflow',
                            data: incomeData,
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                            borderColor: '#10B981',
                            borderRadius: 6,
                            borderWidth: 1
                        },
                        {
                            label: 'Expense Outflow',
                            data: expenseData,
                            backgroundColor: 'rgba(239, 68, 68, 0.7)',
                            borderColor: '#EF4444',
                            borderRadius: 6,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: '#94A3B8', font: { size: 11 } } }
                    },
                    scales: {
                        x: { grid: { color: 'rgba(148,163,184,0.08)' }, ticks: { color: '#94A3B8', font: { size: 10 } } },
                        y: { grid: { color: 'rgba(148,163,184,0.08)' }, ticks: { color: '#94A3B8', font: { size: 10 } } }
                    }
                }
            });
        }

        // 2. Category Pie/Doughnut Chart
        const categoryData = @js($categoryBreakdown);
        const ctxCat = document.getElementById('categoryChart');
        if (ctxCat && categoryData.length > 0) {
            new Chart(ctxCat, {
                type: 'doughnut',
                data: {
                    labels: categoryData.map(c => c.name),
                    datasets: [{
                        data: categoryData.map(c => c.total_amount),
                        backgroundColor: categoryData.map(c => c.color || '#3B82F6'),
                        borderWidth: 2,
                        borderColor: '#0A0F1E'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { color: '#94A3B8', font: { size: 11 } } }
                    }
                }
            });
        }
    });
</script>
@endpush
