@extends('layouts.app')

@section('title', 'Student Dashboard — Campus Coin')

@section('breadcrumbs')
    <!-- Active Dashboard -->
@endsection

@section('content')
<div class="space-y-6">
    <!-- Top Greeting & Quick Action Banner (Requirement 8) -->
    <div class="glass-panel p-6 border-l-4 border-l-blue-500 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-blue-400 uppercase tracking-wider">
                <span>🎓 Campus Coin Portal</span>
                <span>•</span>
                <span>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1 tracking-tight">
                {{ $greeting }}, {{ $user->name }}!
            </h1>
            <p class="text-xs text-slate-400 mt-1">Here is your live campus financial snapshot and savings progress for {{ \Carbon\Carbon::now()->format('F Y') }}.</p>
        </div>

        <!-- Quick-add Buttons (Requirement 8) -->
        <div class="flex items-center gap-2 shrink-0">
            <button @click="$dispatch('open-quick-add')" 
                    class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-lg shadow-blue-600/30 flex items-center gap-2 transition-all hover:scale-102">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Quick Log Entry</span>
            </button>
            <a href="{{ route('ai.coach') }}" 
               class="px-3.5 py-2.5 rounded-xl border border-purple-500/30 bg-purple-500/10 hover:bg-purple-500/20 text-purple-300 text-xs font-semibold flex items-center gap-1.5 transition-all">
                <span>Ask Coach 🤖</span>
            </a>
        </div>
    </div>

    <!-- Core Financial Balance Cards (Requirement 8) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Net Balance -->
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Current Month Balance</span>
                <span class="w-2 h-2 rounded-full {{ $netBalance >= 0 ? 'bg-blue-500' : 'bg-red-500' }}"></span>
            </div>
            <p class="text-2xl font-bold font-mono {{ $netBalance >= 0 ? 'text-white' : 'text-red-400' }} mt-2">
                {{ $user->currencySymbol() }}{{ number_format($netBalance, 2) }}
            </p>
            <div class="mt-2 text-[11px] text-slate-400 flex items-center gap-1">
                <span>{{ $netBalance >= 0 ? 'Healthy surplus' : 'Deficit alert' }}</span>
            </div>
        </div>

        <!-- Monthly Income -->
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Monthly Inflow (Income)</span>
                <span class="text-emerald-400">↑</span>
            </div>
            <p class="text-2xl font-bold font-mono text-emerald-400 mt-2">
                {{ $user->currencySymbol() }}{{ number_format($currentIncome, 2) }}
            </p>
            <div class="mt-2 text-[11px] text-slate-400">
                Baseline: {{ $user->currencySymbol() }}{{ number_format($user->monthly_allowance_baseline ?? 0, 0) }}
            </div>
        </div>

        <!-- Monthly Expense -->
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Monthly Outflow (Expense)</span>
                <span class="text-red-400">↓</span>
            </div>
            <p class="text-2xl font-bold font-mono text-red-400 mt-2">
                {{ $user->currencySymbol() }}{{ number_format($currentExpense, 2) }}
            </p>
            <div class="mt-2 text-[11px] text-slate-400">
                Outflow this cycle
            </div>
        </div>

        <!-- Savings Goal Progress -->
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Monthly Savings Goal</span>
                <span class="font-mono text-blue-400 font-bold">{{ $goalProgress }}%</span>
            </div>
            <p class="text-2xl font-bold font-mono text-white mt-2">
                {{ $user->currencySymbol() }}{{ number_format($currentSavings, 2) }}
            </p>
            <div class="mt-2">
                <div class="w-full bg-slate-900 rounded-full h-1.5 overflow-hidden border border-slate-800">
                    <div class="h-full rounded-full bg-blue-500" style="width: {{ $goalProgress }}%;"></div>
                </div>
                <div class="flex items-center justify-between text-[10px] text-slate-400 mt-1">
                    <span>Target: {{ $user->currencySymbol() }}{{ number_format($monthlyGoal, 0) }}</span>
                    <a href="{{ route('goals.index') }}" class="text-blue-400 hover:text-blue-300 font-semibold inline-flex items-center gap-0.5">
                        <span>Goals</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Widgets Row: Top Category & Budget vs Actual (Requirement 10) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Widget 1: This Month's Top Category (Requirement 10) -->
        <div class="glass-panel p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span>This Month's Top Spending Category</span>
                </h3>
                <span class="text-[11px] text-slate-400">{{ \Carbon\Carbon::now()->format('F Y') }}</span>
            </div>

            @if($topCategory)
                <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg"
                             style="background-color: {{ $topCategory->color ?? '#3B82F6' }}25; color: {{ $topCategory->color ?? '#3B82F6' }};">
                            ●
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-white">{{ $topCategory->name }}</h4>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $topCategory->tx_count }} recorded transactions</p>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-lg font-bold font-mono text-white">{{ $user->currencySymbol() }}{{ number_format($topCategory->total_amount, 2) }}</p>
                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            {{ $topCategoryPercentage }}% of Total Spend
                        </span>
                    </div>
                </div>

                <p class="text-xs text-slate-400 leading-relaxed">
                    💡 <strong>Observation:</strong> You are dedicating {{ $topCategoryPercentage }}% of your expenditures to {{ $topCategory->name }}. Review your limits to keep this category aligned with your baseline.
                </p>
            @else
                <div class="py-8 text-center text-xs text-slate-500">
                    No spending transactions recorded yet for this month. Log purchases to see your top category!
                </div>
            @endif
        </div>

        <!-- Widget 2: Budget vs. Actual (Requirement 10) -->
        <div class="glass-panel p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <span>Budget vs. Actual Consumption</span>
                </h3>
                <a href="{{ route('budgets.index') }}" class="text-[11px] text-blue-400 hover:underline">Manage All Limits &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($budgets->take(4) as $b)
                    @php
                        $pct = $b->percentage;
                        $barColor = $pct >= 100 ? 'bg-red-500' : ($pct >= 80 ? 'bg-amber-400' : 'bg-blue-500');
                    @endphp
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs">
                            <span class="font-medium text-slate-300">{{ $b->category->name ?? 'Category' }}</span>
                            <span class="font-mono text-slate-400">
                                {{ $user->currencySymbol() }}{{ number_format($b->spent_amount, 0) }} / {{ $user->currencySymbol() }}{{ number_format($b->limit_amount, 0) }}
                                (<strong class="{{ $pct >= 100 ? 'text-red-400' : 'text-slate-300' }}">{{ $pct }}%</strong>)
                            </span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                            <div class="h-full rounded-full {{ $barColor }} transition-all duration-300" style="width: {{ min(100, $pct) }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-xs text-slate-500">
                        No active monthly budgets set.
                        <a href="{{ route('budgets.index') }}" class="text-blue-400 underline block mt-1">Set category caps now</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Saving Tips & Highlights (Requirement 9, 26, 27) -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                <span class="text-amber-400">⚡</span>
                <span>Personalized Saving Tips for You</span>
            </h2>
            <a href="{{ route('insights.index') }}" class="text-xs text-blue-400 hover:underline">View All Tips &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($savingTips as $tip)
                <div class="glass-panel p-4 flex flex-col justify-between space-y-2 border-l-2 border-l-emerald-500">
                    <div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-semibold uppercase">
                            <span>{{ $tip->category ?? 'General' }}</span>
                            @if($tip->impact_amount > 0)
                                <span class="text-emerald-400 font-mono">+{{ $user->currencySymbol() }}{{ number_format($tip->impact_amount, 0) }}</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-xs text-white mt-1">{{ $tip->title }}</h4>
                        <p class="text-[11px] text-slate-300 mt-1 leading-relaxed">{{ Str::limit($tip->description, 110) }}</p>
                    </div>

                    <div class="pt-2 border-t border-slate-800/60 flex justify-between items-center text-[10px]">
                        <form method="POST" action="{{ route('tips.bookmark', $tip) }}">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-amber-400">
                                {{ $tip->is_bookmarked ? '★ Bookmarked' : '☆ Bookmark' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('tips.dismiss', $tip) }}">
                            @csrf
                            <button type="submit" class="text-slate-500 hover:text-slate-300">Dismiss</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full glass-panel py-6 text-center text-xs text-slate-500">
                    No active saving tips. You're maintaining excellent spending discipline!
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Transactions Table & Recently Viewed/Edited Module (Requirement 13 & 38) -->
    <div class="glass-panel overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-sm font-bold text-white tracking-tight">Recent Transactions</h3>
            <a href="{{ route('transactions.index') }}" class="text-xs text-blue-400 hover:underline">View All &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900/60 text-slate-400 font-semibold border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @forelse($recentTransactions as $tx)
                        <tr class="hover:bg-slate-800/20 transition-colors">
                            <td class="py-3 px-4 font-mono text-slate-300 whitespace-nowrap">{{ \Carbon\Carbon::parse($tx->date)->format('M d, Y') }}</td>
                            <td class="py-3 px-4 font-medium text-slate-200">{{ $tx->description }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[11px]" style="background-color: {{ $tx->category->color ?? '#3B82F6' }}20; color: {{ $tx->category->color ?? '#3B82F6' }};">
                                    {{ $tx->category->name ?? '—' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap uppercase text-[10px] font-semibold {{ $tx->type === 'income' ? 'text-emerald-400' : 'text-slate-400' }}">
                                {{ $tx->type }}
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap font-mono font-bold {{ $tx->type === 'income' ? 'text-emerald-400' : 'text-slate-200' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }}{{ $user->currencySymbol() }}{{ number_format($tx->amount, 2) }}
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <form method="POST" action="{{ route('transactions.destroy', $tx) }}" onsubmit="return confirm('Delete this transaction? Audit history is preserved.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-slate-500 hover:text-red-400 text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-xs text-slate-500">No recent transactions logged.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recently Viewed / Edited Across Sessions (Requirement 38) -->
    <div x-data="recentlyViewedWidget()" x-init="load()" x-show="recentItems.length > 0" x-cloak class="glass-panel p-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Recently Viewed / Edited Transactions (Cross-Session)</h3>
        <div class="flex flex-wrap gap-2">
            <template x-for="item in recentItems" :key="item.id">
                <div class="px-3 py-1.5 rounded-lg bg-slate-900/60 border border-slate-800 text-xs text-slate-300 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    <span class="font-medium" x-text="item.description"></span>
                    <span class="font-mono text-slate-400" x-text="'(' + item.amount + ')'"></span>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function recentlyViewedWidget() {
        return {
            recentItems: [],
            load() {
                try {
                    this.recentItems = JSON.parse(localStorage.getItem('cc_recent_txs') || '[]');
                } catch(e) {
                    this.recentItems = [];
                }
            }
        };
    }
</script>
@endpush
