@extends('layouts.app')

@section('title', 'Budget Goals & Alerts — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">Budgets</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ addBudgetOpen: false }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Category Budgets & Spending Limits</h1>
            <p class="text-xs text-slate-400 mt-1">Set monthly caps per category. Monitor consumption in real-time with automated threshold alerts.</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Month Selector -->
            <form method="GET" action="{{ route('budgets.index') }}" class="flex items-center gap-2">
                <input type="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()"
                       class="px-3 py-1.5 rounded-xl border bg-slate-900/60 border-slate-700 text-xs text-slate-200">
            </form>

            <button @click="addBudgetOpen = true" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30 flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Set Budget Cap</span>
            </button>
        </div>
    </div>

    <!-- Overall Budget Consumption Card (Requirement 30) -->
    <div class="glass-panel p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Month Budget Overview ({{ \Carbon\Carbon::parse($selectedMonth.'-01')->format('F Y') }})</span>
                <div class="flex items-baseline gap-3 mt-1">
                    <span class="text-2xl font-bold text-white">{{ $user->currencySymbol() }}{{ number_format($totalBudgetSpent, 2) }}</span>
                    <span class="text-xs text-slate-400">spent of {{ $user->currencySymbol() }}{{ number_format($totalBudgetLimit, 2) }} limit</span>
                </div>
            </div>

            <div class="text-right">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Consumption</span>
                <p class="text-2xl font-bold {{ $overallBudgetPercentage >= 100 ? 'text-red-400' : ($overallBudgetPercentage >= 80 ? 'text-amber-400' : 'text-emerald-400') }}">
                    {{ $overallBudgetPercentage }}%
                </p>
            </div>
        </div>

        <!-- Master Progress Bar -->
        <div class="mt-4">
            <div class="w-full bg-slate-900 rounded-full h-3 overflow-hidden p-0.5 border border-slate-800">
                <div class="h-full rounded-full transition-all duration-500 {{ $overallBudgetPercentage >= 100 ? 'bg-red-500' : ($overallBudgetPercentage >= 80 ? 'bg-amber-400' : 'bg-gradient-to-r from-blue-500 to-emerald-400') }}"
                     style="width: {{ min(100, $overallBudgetPercentage) }}%;"></div>
            </div>
            <div class="flex justify-between text-[11px] text-slate-400 mt-2 font-mono">
                <span>0% Safe</span>
                <span>80% Warning Threshold</span>
                <span>100% Max Budget</span>
            </div>
        </div>
    </div>

    <!-- Active Budgets Grid (Requirement 29 & 30) -->
    <div class="space-y-3">
        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Active Category Limits ({{ $budgets->count() }})</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($budgets as $b)
                @php
                    $pct = $b->percentage;
                    $statusColor = match($b->status) {
                        'exceeded' => 'text-red-400 bg-red-500/10 border-red-500/20',
                        'warning' => 'text-amber-400 bg-amber-500/10 border-amber-500/20',
                        default => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20'
                    };
                    $barColor = match($b->status) {
                        'exceeded' => 'bg-red-500',
                        'warning' => 'bg-amber-400',
                        default => 'bg-blue-500'
                    };
                @endphp
                <div class="glass-panel p-5 space-y-4 relative overflow-hidden">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0"
                                 style="background-color: {{ $b->category->color ?? '#3B82F6' }}25; color: {{ $b->category->color ?? '#3B82F6' }};">
                                ●
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-200">{{ $b->category->name ?? 'Category' }}</h3>
                                <p class="text-[11px] text-slate-400">Limit: {{ $user->currencySymbol() }}{{ number_format($b->limit_amount, 2) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $statusColor }}">
                                {{ $b->status }}
                            </span>
                            <form method="POST" action="{{ route('budgets.destroy', $b) }}" onsubmit="return confirm('Remove budget cap for this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-red-400 transition-colors" title="Delete Budget">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Spent: <strong class="text-slate-200 font-mono">{{ $user->currencySymbol() }}{{ number_format($b->spent_amount, 2) }}</strong></span>
                            <span class="font-mono font-bold {{ $pct >= 100 ? 'text-red-400' : 'text-slate-300' }}">{{ $pct }}%</span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                            <div class="h-full rounded-full transition-all duration-500 {{ $barColor }}" style="width: {{ min(100, $pct) }}%;"></div>
                        </div>
                    </div>

                    <div class="pt-1 flex items-center justify-between text-[11px] text-slate-400 border-t border-slate-800/60">
                        <span>Remaining:</span>
                        <span class="font-mono font-semibold {{ $b->remaining_amount <= 0 ? 'text-red-400' : 'text-emerald-400' }}">
                            {{ $user->currencySymbol() }}{{ number_format($b->remaining_amount, 2) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full glass-panel py-12 text-center text-slate-500">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                    <p class="text-sm font-semibold">No category budgets established for this month</p>
                    <p class="text-xs text-slate-400 mt-1">Click "Set Budget Cap" above to set limits for Food, Transport, Hostel, etc.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Set Budget Modal (Requirement 29) -->
    <div x-show="addBudgetOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div @click.outside="addBudgetOpen = false" class="glass-panel w-full max-w-md p-6 border shadow-2xl relative"
             :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
            <div class="flex items-center justify-between pb-3 border-b border-slate-700/50">
                <h3 class="text-base font-bold">Set Monthly Category Budget</h3>
                <button @click="addBudgetOpen = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="{{ route('budgets.store') }}" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Target Month *</label>
                    <input type="month" name="month" value="{{ $selectedMonth }}" required
                           class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Expense Category *</label>
                    <select name="category_id" required class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                        <option value="">-- Choose Category --</option>
                        @foreach($expenseCategories as $ec)
                            <option value="{{ $ec->id }}">{{ $ec->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Spending Limit Amount ({{ $user->currencySymbol() }}) *</label>
                    <input type="number" step="1" min="10" name="limit_amount" placeholder="e.g. 5000" required
                           class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                    <p class="text-[10px] text-slate-500 mt-1">Automatic alert dispatched when spending reaches 80% or 100%.</p>
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="addBudgetOpen = false" class="px-3 py-1.5 rounded-lg text-xs text-slate-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold">Save Budget Cap</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
