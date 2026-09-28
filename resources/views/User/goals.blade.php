@extends('layouts.app')

@section('title', 'Savings Goals & Milestones — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">Savings Goals</span>
@endsection

@section('content')
<div x-data="goalManager()" class="space-y-6">
    <!-- Top Header & Actions -->
    <div class="glass-panel p-6 border-l-4 border-l-emerald-500 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-400 uppercase tracking-wider">
                <span>🎯 Goal Tracking & Wealth Building</span>
                <span>•</span>
                <span>{{ \Carbon\Carbon::now()->format('F Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1 tracking-tight">
                Savings Goals & Milestones
            </h1>
            <p class="text-xs text-slate-400 mt-1">
                Plan, monitor, and achieve your financial targets. Auto-calculated monthly savings keep you on track.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button @click="openCreateModal()" 
                    class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/30 flex items-center gap-2 transition-all hover:scale-102">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Create New Goal</span>
            </button>
            <a href="{{ route('profile.index') }}" 
               class="px-3.5 py-2.5 rounded-xl border border-slate-700 hover:border-slate-600 text-slate-300 hover:text-white text-xs font-medium flex items-center gap-1.5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Settings</span>
            </a>
        </div>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Target Amount -->
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Total Target Amount</span>
                <span class="p-1 rounded-md bg-blue-500/10 text-blue-400">🎯</span>
            </div>
            <p class="text-2xl font-bold font-mono text-white mt-2">
                {{ $user->currencySymbol() }}{{ number_format($totalTarget, 2) }}
            </p>
            <div class="mt-2 text-[11px] text-slate-400">
                Across {{ $goals->count() }} active goals
            </div>
        </div>

        <!-- Total Saved Amount -->
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Total Amount Saved</span>
                <span class="p-1 rounded-md bg-emerald-500/10 text-emerald-400">💰</span>
            </div>
            <p class="text-2xl font-bold font-mono text-emerald-400 mt-2">
                {{ $user->currencySymbol() }}{{ number_format($totalSaved, 2) }}
            </p>
            <div class="mt-2 text-[11px] text-slate-400">
                Remaining: {{ $user->currencySymbol() }}{{ number_format(max(0, $totalTarget - $totalSaved), 2) }}
            </div>
        </div>

        <!-- Overall Progress -->
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Overall Completion</span>
                <span class="font-mono text-emerald-400 font-bold">{{ $overallProgress }}%</span>
            </div>
            <p class="text-2xl font-bold font-mono text-white mt-2">
                {{ $overallProgress }}%
            </p>
            <div class="mt-2">
                <div class="w-full bg-slate-900 rounded-full h-1.5 overflow-hidden border border-slate-800">
                    <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-emerald-400 transition-all duration-500" style="width: {{ $overallProgress }}%;"></div>
                </div>
            </div>
        </div>

        <!-- Required Monthly Savings -->
        @php
            $activeGoals = $goals->where('status', '!=', 'completed');
            $totalMonthlyRequired = $activeGoals->sum(function($g) {
                return $g->monthlyTarget();
            });
        @endphp
        <div class="glass-panel p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                <span>Monthly Savings Needed</span>
                <span class="p-1 rounded-md bg-purple-500/10 text-purple-400">📅</span>
            </div>
            <p class="text-2xl font-bold font-mono text-purple-400 mt-2">
                {{ $user->currencySymbol() }}{{ number_format($totalMonthlyRequired, 2) }}
            </p>
            <div class="mt-2 text-[11px] text-slate-400">
                To reach all goals in target duration
            </div>
        </div>
    </div>

    <!-- Goals List / Grid -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h2 class="text-lg font-bold text-white">Your Financial Goals</h2>
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-300">{{ $goals->count() }}</span>
            </div>
            <button @click="openCreateModal()" class="text-xs text-emerald-400 hover:text-emerald-300 font-semibold flex items-center gap-1">
                <span>+ Add Goal</span>
            </button>
        </div>

        @if($goals->isEmpty())
            <div class="glass-panel p-10 text-center space-y-4">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-3xl">
                    🎯
                </div>
                <div class="max-w-md mx-auto">
                    <h3 class="text-lg font-bold text-white">No Savings Goals Yet</h3>
                    <p class="text-xs text-slate-400 mt-1">
                        Set target goals such as an Emergency Fund, Semester Supplies, Tech Gadgets, or Travel. Specify your target duration and we'll calculate how much to save every month!
                    </p>
                </div>
                <button @click="openCreateModal()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/30 transition-all">
                    Create Your First Goal
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($goals as $goal)
                    @php
                        $progress = $goal->progressPercentage();
                        $monthlyNeeded = $goal->monthlyTarget();
                        $remainingAmount = $goal->remainingAmount();
                        $isCompleted = $goal->status === 'completed' || $progress >= 100;
                        
                        $categoryIcons = [
                            'Academic' => '📚',
                            'Emergency' => '🛡️',
                            'Tech & Career' => '💻',
                            'Gadgets' => '💻',
                            'Travel' => '✈️',
                            'Hostel & Living' => '🏠',
                            'Personal' => '🎁',
                        ];
                        $catIcon = $categoryIcons[$goal->category] ?? '🎯';
                    @endphp
                    <div class="glass-panel p-5 flex flex-col justify-between space-y-4 border transition-all duration-200 hover:border-slate-700 relative overflow-hidden group">
                        @if($isCompleted)
                            <div class="absolute -right-8 top-4 rotate-45 bg-emerald-500 text-white text-[10px] font-bold py-0.5 px-8 shadow-md">
                                COMPLETED
                            </div>
                        @endif

                        <!-- Card Top Header -->
                        <div>
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-2xl p-2 rounded-xl bg-slate-800/60 border border-slate-700/50">{{ $catIcon }}</span>
                                    <div>
                                        <h3 class="font-bold text-base text-white group-hover:text-blue-400 transition-colors">{{ $goal->title }}</h3>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                {{ $goal->category ?: 'General' }}
                                            </span>
                                            <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <span>{{ $goal->duration_months }} {{ Str::plural('Month', $goal->duration_months) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($goal->notes)
                                <p class="text-xs text-slate-400 mt-3 line-clamp-2 italic">
                                    "{{ $goal->notes }}"
                                </p>
                            @endif
                        </div>

                        <!-- Financial Figures -->
                        <div class="bg-slate-900/60 rounded-xl p-3 border border-slate-800 space-y-2">
                            <div class="flex justify-between items-baseline">
                                <span class="text-xs text-slate-400">Total Goal Target:</span>
                                <span class="font-mono font-bold text-white text-sm">{{ $user->currencySymbol() }}{{ number_format($goal->target_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-baseline">
                                <span class="text-xs text-slate-400">Amount Saved:</span>
                                <span class="font-mono font-bold text-emerald-400 text-sm">{{ $user->currencySymbol() }}{{ number_format($goal->current_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-baseline border-t border-slate-800/60 pt-1.5">
                                <span class="text-xs text-slate-400">Remaining to Save:</span>
                                <span class="font-mono font-semibold text-slate-300 text-xs">{{ $user->currencySymbol() }}{{ number_format($remainingAmount, 2) }}</span>
                            </div>
                            
                            <!-- Monthly Savings Calculation (Requirement 5) -->
                            <div class="mt-2 pt-2 border-t border-slate-800/80 flex items-center justify-between text-xs bg-emerald-500/5 -mx-3 -mb-3 p-2.5 rounded-b-xl">
                                <div class="flex items-center gap-1.5 text-emerald-400 font-medium">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    <span>Save per month:</span>
                                </div>
                                <span class="font-mono font-extrabold text-emerald-400 text-sm">
                                    {{ $user->currencySymbol() }}{{ number_format($monthlyNeeded, 2) }}/mo
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar & Indicator -->
                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-medium">Completion Progress</span>
                                <span class="font-mono font-bold {{ $isCompleted ? 'text-emerald-400' : 'text-blue-400' }}">{{ $progress }}%</span>
                            </div>
                            <div class="w-full bg-slate-900 rounded-full h-2.5 overflow-hidden border border-slate-800 p-0.5">
                                <div class="h-full rounded-full {{ $isCompleted ? 'bg-emerald-500' : 'bg-gradient-to-r from-blue-500 to-emerald-400' }} transition-all duration-500" 
                                     style="width: {{ $progress }}%;"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-500 font-mono">
                                <span>{{ $user->currencySymbol() }}0</span>
                                <span>{{ $isCompleted ? 'Goal Completed 🎉' : round(100 - $progress, 1) . '% remaining' }}</span>
                                <span>{{ $user->currencySymbol() }}{{ number_format($goal->target_amount, 0) }}</span>
                            </div>
                        </div>

                        <!-- Card Actions: Deposit, Edit, Delete -->
                        <div class="pt-2 border-t border-slate-800/60 flex items-center justify-between gap-2">
                            <!-- Quick Deposit Button -->
                            <button @click="openDepositModal({{ json_encode($goal) }})"
                                    class="flex-1 py-1.5 px-3 rounded-lg bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-400 hover:text-emerald-300 border border-emerald-500/30 text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Save Funds</span>
                            </button>

                            <!-- Edit Button -->
                            <button @click="openEditModal({{ json_encode($goal) }})"
                                    class="p-2 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 border border-transparent hover:border-blue-500/20 transition-colors"
                                    title="Edit Goal">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>

                            <!-- Delete Form & Button -->
                            <form method="POST" action="{{ route('goals.destroy', $goal) }}" onsubmit="return confirm('Are you sure you want to delete this goal and its records?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 border border-transparent hover:border-red-500/20 transition-colors"
                                        title="Delete Goal">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Create Goal Modal -->
    <div x-show="showCreateModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
         @keydown.escape.window="showCreateModal = false">
        <div @click.outside="showCreateModal = false" 
             class="glass-panel p-6 w-full max-w-lg border border-slate-700 rounded-2xl shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🎯</span>
                    <h3 class="text-base font-bold text-white">Create New Savings Goal</h3>
                </div>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-white text-lg">&times;</button>
            </div>

            <form method="POST" action="{{ route('goals.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Goal Title *</label>
                    <input type="text" name="title" x-model="formCreate.title" required placeholder="e.g. Laptop Upgrade, Semester Fees"
                           class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-emerald-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Category</label>
                        <select name="category" x-model="formCreate.category" class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white">
                            <option value="Academic">Academic 📚</option>
                            <option value="Emergency">Emergency 🛡️</option>
                            <option value="Tech & Career">Tech & Career 💻</option>
                            <option value="Hostel & Living">Hostel & Living 🏠</option>
                            <option value="Travel">Travel ✈️</option>
                            <option value="Personal">Personal 🎁</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Target Amount ({{ $user->currencySymbol() }}) *</label>
                        <input type="number" step="100"  name="target_amount" x-model.number="formCreate.target_amount" required placeholder="50000"
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-emerald-500 focus:outline-none font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Duration (Months) *</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="1" max="120" name="duration_months" x-model.number="formCreate.duration_months" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-emerald-500 focus:outline-none font-mono">
                            <span class="text-xs text-slate-400 shrink-0">months</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Initial Deposit (Optional)</label>
                        <input type="number" step="10" min="0" name="initial_deposit" x-model.number="formCreate.initial_deposit" placeholder="0"
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-emerald-500 focus:outline-none font-mono">
                    </div>
                </div>

                <!-- Auto-Calculation Box (Requirement 5) -->
                <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 space-y-1">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span>Calculated Monthly Saving:</span>
                        <span class="font-mono text-base font-bold">
                            {{ $user->currencySymbol() }}<span x-text="calculateMonthly(formCreate.target_amount, formCreate.duration_months)"></span>/mo
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-400">
                        Saving this amount every month will successfully reach your target in <span class="text-emerald-300 font-semibold" x-text="formCreate.duration_months || 1"></span> months.
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Notes / Motivation (Optional)</label>
                    <textarea name="notes" rows="2" x-model="formCreate.notes" placeholder="Why are you saving for this? Any milestone targets..."
                              class="w-full px-3.5 py-2 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-emerald-500 focus:outline-none"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-800">
                    <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-600/30">
                        Create Goal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Goal Modal (Requirements 4 & 5) -->
    <div x-show="showEditModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
         @keydown.escape.window="showEditModal = false">
        <div @click.outside="showEditModal = false" 
             class="glass-panel p-6 w-full max-w-lg border border-slate-700 rounded-2xl shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="text-xl">✏️</span>
                    <h3 class="text-base font-bold text-white">Edit Savings Goal</h3>
                </div>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-white text-lg">&times;</button>
            </div>

            <form :action="'/goals/' + formEdit.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Goal Title *</label>
                    <input type="text" name="title" x-model="formEdit.title" required
                           class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Category</label>
                        <select name="category" x-model="formEdit.category" class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white">
                            <option value="Academic">Academic 📚</option>
                            <option value="Emergency">Emergency 🛡️</option>
                            <option value="Tech & Career">Tech & Career 💻</option>
                            <option value="Hostel & Living">Hostel & Living 🏠</option>
                            <option value="Travel">Travel ✈️</option>
                            <option value="Personal">Personal 🎁</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Target Amount ({{ $user->currencySymbol() }}) *</label>
                        <input type="number" step="100" min="1" name="target_amount" x-model.number="formEdit.target_amount" required
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-blue-500 focus:outline-none font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Duration (Months) *</label>
                        <input type="number" min="1" max="120" name="duration_months" x-model.number="formEdit.duration_months" required
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-blue-500 focus:outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Current Amount Saved</label>
                        <input type="number" step="10" min="0" name="current_amount" x-model.number="formEdit.current_amount"
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-blue-500 focus:outline-none font-mono">
                    </div>
                </div>

                <!-- Auto-Calculation Box for Edit -->
                <div class="p-3.5 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 space-y-1">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span>Calculated Monthly Saving:</span>
                        <span class="font-mono text-base font-bold">
                            {{ $user->currencySymbol() }}<span x-text="calculateMonthly(formEdit.target_amount, formEdit.duration_months)"></span>/mo
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-slate-400">
                        <span>Remaining pace:</span>
                        <span class="font-mono text-slate-300">
                            {{ $user->currencySymbol() }}<span x-text="calculateRemainingMonthly(formEdit.target_amount, formEdit.current_amount, formEdit.duration_months)"></span>/mo
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Status</label>
                        <select name="status" x-model="formEdit.status" class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white">
                            <option value="in_progress">In Progress ⏳</option>
                            <option value="completed">Completed 🎉</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Notes</label>
                        <input type="text" name="notes" x-model="formEdit.notes"
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-800">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Deposit / Save Funds Modal -->
    <div x-show="showDepositModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
         @keydown.escape.window="showDepositModal = false">
        <div @click.outside="showDepositModal = false" 
             class="glass-panel p-6 w-full max-w-md border border-slate-700 rounded-2xl shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="text-xl">💰</span>
                    <h3 class="text-base font-bold text-white">Log Savings Towards Goal</h3>
                </div>
                <button @click="showDepositModal = false" class="text-slate-400 hover:text-white text-lg">&times;</button>
            </div>

            <form :action="'/goals/' + depositGoal.id + '/deposit'" method="POST" class="space-y-4">
                @csrf
                <div>
                    <span class="text-xs text-slate-400 block mb-1">Selected Goal</span>
                    <p class="font-bold text-white text-sm" x-text="depositGoal.title"></p>
                    <p class="text-xs text-slate-400 font-mono mt-0.5">
                        Current: {{ $user->currencySymbol() }}<span x-text="Number(depositGoal.current_amount || 0).toLocaleString()"></span> of {{ $user->currencySymbol() }}<span x-text="Number(depositGoal.target_amount || 0).toLocaleString()"></span>
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Deposit Amount ({{ $user->currencySymbol() }}) *</label>
                    <input
                          type="number"
                          step="any"
                          min="1"
                          name="amount"
                          required
                          placeholder="e.g. 2500"
                          class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900 border-slate-700 text-sm text-white focus:border-emerald-500                   focus:outline-none font-mono"
    >

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Note (Optional)</label>
                    <input type="text" name="notes" placeholder="e.g. Saved from freelance gig or stipend"
                           class="w-full px-3.5 py-2 rounded-xl border bg-slate-900 border-slate-700 text-xs text-white focus:border-emerald-500 focus:outline-none">
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-800">
                    <button type="button" @click="showDepositModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-600/30">
                        Confirm Deposit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function goalManager() {
        return {
            showCreateModal: false,
            showEditModal: false,
            showDepositModal: false,
            depositGoal: {},

            formCreate: {
                title: '',
                category: 'Academic',
                target_amount: 20000,
                duration_months: 6,
                initial_deposit: '',
                notes: ''
            },

            formEdit: {
                id: '',
                title: '',
                category: '',
                target_amount: 0,
                current_amount: 0,
                duration_months: 1,
                status: 'in_progress',
                notes: ''
            },

            openCreateModal() {
                this.showCreateModal = true;
            },

            openEditModal(goal) {
                this.formEdit = {
                    id: goal.id,
                    title: goal.title,
                    category: goal.category || 'Academic',
                    target_amount: Number(goal.target_amount),
                    current_amount: Number(goal.current_amount),
                    duration_months: Number(goal.duration_months) || 1,
                    status: goal.status || 'in_progress',
                    notes: goal.notes || ''
                };
                this.showEditModal = true;
            },

            openDepositModal(goal) {
                this.depositGoal = goal;
                this.showDepositModal = true;
            },

            calculateMonthly(target, duration) {
                const t = parseFloat(target) || 0;
                const d = Math.max(1, parseInt(duration) || 1);
                return (t / d).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            },

            calculateRemainingMonthly(target, current, duration) {
                const t = parseFloat(target) || 0;
                const c = parseFloat(current) || 0;
                const d = Math.max(1, parseInt(duration) || 1);
                const rem = Math.max(0, t - c);
                return (rem / d).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        };
    }
</script>
@endpush
@endsection
