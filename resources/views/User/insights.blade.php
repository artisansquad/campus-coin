@extends('layouts.app')

@section('title', 'AI Monthly Insights & Saving Tips — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">AI Insights & Tips</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Month Switcher and Regenerate Trigger -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-sm">✨</span>
                <span>AI Monthly Insights & Saving Engine</span>
            </h1>
            <p class="text-xs text-slate-400 mt-1">Autonomous intelligence analyzing trends, detecting budget spikes, and providing actionable advice.</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Review Past Months (Requirement 25) -->
            <form method="GET" action="{{ route('insights.index') }}" class="flex items-center gap-2">
                <select name="month" onchange="this.form.submit()"
                        class="px-3 py-1.5 rounded-xl border bg-slate-900/60 border-slate-700 text-xs text-slate-200">
                    @forelse($insightHistory as $ih)
                        <option value="{{ $ih->month }}" {{ $selectedMonth === $ih->month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($ih->month.'-01')->format('F Y') }}
                        </option>
                    @empty
                        <option value="{{ $selectedMonth }}">{{ \Carbon\Carbon::parse($selectedMonth.'-01')->format('F Y') }}</option>
                    @endforelse
                </select>
            </form>

            <form method="POST" action="{{ route('insights.generate') }}">
                @csrf
                <input type="hidden" name="month" value="{{ $selectedMonth }}">
                <button type="submit" 
                        class="px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30 flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Regenerate Analysis</span>
                </button>
            </form>
        </div>
    </div>

    <!-- AI Plain-Language Narrative Summary (Requirement 22 & 32) -->
    <div class="glass-panel p-6 border-l-4 border-l-blue-500 relative">
        <div class="flex items-start justify-between gap-4">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    <span>Monthly Narrative Assessment • {{ \Carbon\Carbon::parse($selectedMonth.'-01')->format('F Y') }}</span>
                </div>
                <p class="text-sm text-slate-200 leading-relaxed font-medium">
                    {{ $currentInsight->summary_text ?? 'Generating your monthly insights...' }}
                </p>
            </div>

            <!-- Bookmark Insight Trigger (Requirement 32) -->
            @if($currentInsight && $currentInsight->id)
                <form method="POST" action="{{ route('insights.bookmark', $currentInsight) }}">
                    @csrf
                    <button type="submit" 
                            class="p-2 rounded-xl border transition-colors {{ $currentInsight->is_bookmarked ? 'bg-amber-500/20 text-amber-400 border-amber-500/30' : 'border-slate-700 text-slate-400 hover:text-amber-400' }}"
                            title="{{ $currentInsight->is_bookmarked ? 'Unbookmark Insight' : 'Bookmark Insight' }}">
                        <svg class="w-5 h-5 {{ $currentInsight->is_bookmarked ? 'fill-amber-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    </button>
                </form>
            @endif
        </div>

        <!-- Spike Alert & Actionable Advice (Requirement 23 & 24) -->
        @if($currentInsight && $currentInsight->flagged_category)
            <div class="mt-5 pt-4 border-t border-slate-800 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    <div class="text-xs">
                        <strong class="font-bold block">Growth Spike Flagged: {{ $currentInsight->flagged_category }}</strong>
                        <span>Accelerated +{{ $currentInsight->growth_percentage }}% over prior cycles.</span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-300 flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-xs">
                        <strong class="font-bold block text-blue-200">Actionable Financial Advice</strong>
                        <span>{{ $currentInsight->tip_text }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- System Intelligence: Next Month Spending Forecast (Requirement 39) -->
    <div class="glass-panel p-5 bg-gradient-to-r from-blue-900/20 via-indigo-900/10 to-transparent">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Next Month Spending Forecast (Historical Trend Projection)</span>
                </span>
                <p class="text-xs text-slate-400 mt-1">Calculated via 3-month rolling trailing expense averages and allowance baselines.</p>
            </div>

            <div class="flex items-center gap-6">
                <div>
                    <span class="text-[11px] text-slate-400">Projected Spend</span>
                    <p class="text-lg font-bold font-mono text-white">{{ $user->currencySymbol() }}{{ number_format($forecast['projected_spend'] ?? 0, 2) }}</p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400">Recommended Daily Cap</span>
                    <p class="text-lg font-bold font-mono text-emerald-400">{{ $user->currencySymbol() }}{{ number_format($forecast['recommended_daily_limit'] ?? 0, 2) }}</p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400">Confidence</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        {{ $forecast['confidence_score'] ?? 'Moderate' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Saving Tips Engine (Requirement 26, 27, 28, 32) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Personalized Saving Tips Engine</span>
            </h2>
            <span class="text-xs text-slate-400 font-medium">Ranked by potential savings impact</span>
        </div>

        @php
            $activeTips = Auth::user()->savingTips()->active()->orderByDesc('is_pinned')->orderByDesc('impact_amount')->get();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($activeTips as $tip)
                <div class="glass-panel p-5 space-y-3 relative {{ $tip->is_pinned ? 'border-blue-500/40' : '' }}">
                    @if($tip->is_pinned)
                        <div class="absolute top-3 right-3 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center gap-1">
                            <span>📌 Pinned</span>
                        </div>
                    @endif

                    <div class="pr-20">
                        <h3 class="text-sm font-bold text-white">{{ $tip->title }}</h3>
                        <span class="text-[11px] text-slate-400 uppercase font-semibold">{{ $tip->category ?? 'General' }}</span>
                    </div>

                    <p class="text-xs text-slate-300 leading-relaxed">{{ $tip->description }}</p>

                    @if($tip->impact_amount > 0)
                        <div class="pt-2 flex items-center gap-2 text-xs">
                            <span class="text-slate-400">Potential Savings:</span>
                            <span class="font-bold font-mono text-emerald-400">+{{ $user->currencySymbol() }}{{ number_format($tip->impact_amount, 2) }}/mo</span>
                        </div>
                    @endif

                    <!-- Tip Actions: Pin, Bookmark, Dismiss (Requirement 28 & 32) -->
                    <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <!-- Pin Form -->
                            <form method="POST" action="{{ route('tips.pin', $tip) }}">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-lg border border-slate-800 hover:border-slate-700 text-slate-400 hover:text-white transition-colors text-[11px]">
                                    {{ $tip->is_pinned ? 'Unpin' : 'Pin to Top' }}
                                </button>
                            </form>

                            <!-- Bookmark Form -->
                            <form method="POST" action="{{ route('tips.bookmark', $tip) }}">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-lg border transition-colors text-[11px] {{ $tip->is_bookmarked ? 'border-amber-500/40 text-amber-400 bg-amber-500/10' : 'border-slate-800 text-slate-400 hover:text-amber-400' }}">
                                    {{ $tip->is_bookmarked ? '★ Bookmarked' : '☆ Bookmark' }}
                                </button>
                            </form>
                        </div>

                        <!-- Dismiss Form -->
                        <form method="POST" action="{{ route('tips.dismiss', $tip) }}">
                            @csrf
                            <button type="submit" class="text-slate-500 hover:text-slate-300 text-[11px] transition-colors">
                                Dismiss
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full glass-panel py-8 text-center text-xs text-slate-500">
                    No active saving tips right now. Keep logging transactions to receive intelligent suggestions!
                </div>
            @endforelse
        </div>
    </div>

    <!-- Bookmarked Archive Section (Requirement 32) -->
    @if($bookmarkedInsights->count() > 0 || $bookmarkedTips->count() > 0)
        <div class="space-y-4 pt-4">
            <h2 class="text-base font-bold text-slate-200 flex items-center gap-2">
                <span class="text-amber-400">★</span>
                <span>Bookmarked Insights & Tips</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($bookmarkedInsights as $bi)
                    <div class="glass-panel p-4 space-y-2 border-amber-500/30">
                        <span class="text-[10px] uppercase font-bold text-amber-400">Insight • {{ \Carbon\Carbon::parse($bi->month.'-01')->format('M Y') }}</span>
                        <p class="text-xs text-slate-300">{{ $bi->summary_text }}</p>
                    </div>
                @endforeach

                @foreach($bookmarkedTips as $bt)
                    <div class="glass-panel p-4 space-y-2 border-amber-500/30">
                        <span class="text-[10px] uppercase font-bold text-emerald-400">Saving Tip • {{ $bt->title }}</span>
                        <p class="text-xs text-slate-300">{{ $bt->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
