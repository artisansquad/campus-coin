@extends('layouts.app')

@section('title', 'Student Profile & Settings — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">Profile & Settings</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header with Goal Button (Requirement 3) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Student Profile & Settings</h1>
            <p class="text-xs text-slate-400 mt-1">Configure your academic year, baseline monthly allowance, savings target, and password.</p>
        </div>
        <div>
            <a href="{{ route('goals.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/30 transition-all hover:scale-102">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Savings Goals</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Summary Card -->
        <div class="glass-panel p-6 flex flex-col items-center text-center space-y-4">
            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-2xl font-bold text-white shadow-xl shadow-blue-500/20">
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
            </div>

            <div>
                <h2 class="text-lg font-bold text-white">{{ $user->getFullNameAttribute() }}</h2>
                <p class="text-xs text-slate-400">{{ $user->email }}</p>
                <div class="mt-2 flex flex-wrap items-center justify-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        {{ $user->academic_year ?? 'Undergraduate' }}
                    </span>
                    @if($user->student_id)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-mono font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            ID: {{ $user->student_id }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="w-full pt-4 border-t border-slate-800 space-y-2 text-xs text-left">
                <div class="flex justify-between py-1 border-b border-slate-800/40">
                    <span class="text-slate-400">Student ID</span>
                    <span class="font-semibold font-mono text-blue-400">{{ $user->student_id ?: 'STU-' . str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/40">
                    <span class="text-slate-400">Account Role</span>
                    <span class="font-semibold text-slate-200 uppercase">{{ $user->role }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/40">
                    <span class="text-slate-400">Preferred Currency</span>
                    <span class="font-semibold text-slate-200">{{ $user->preferred_currency ?? 'PKR' }} ({{ $user->currencySymbol() }})</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/40">
                    <span class="text-slate-400">Total Transactions</span>
                    <span class="font-semibold font-mono text-slate-200">{{ $user->transactions()->count() }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/40">
                    <span class="text-slate-400">Joined</span>
                    <span class="text-slate-200">{{ $user->created_at?->format('M d, Y') ?? 'Recently' }}</span>
                </div>
                <div class="pt-3">
                    <a href="{{ route('goals.index') }}" class="w-full py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold flex items-center justify-center gap-2 shadow-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Manage Savings Goals</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Forms Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Details Form (Requirement 4) -->
            <div class="glass-panel p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                    <h3 class="text-sm font-bold text-slate-200 uppercase tracking-wider">Financial Baseline & Personal Info</h3>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">First Name *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Academic Year / Degree</label>
                            <input type="text" name="academic_year" value="{{ old('academic_year', $user->academic_year) }}" placeholder="e.g. 3rd Year / Computer Science"
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Preferred Currency</label>
                            <select name="preferred_currency" class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                                <option value="PKR" {{ $user->preferred_currency === 'PKR' ? 'selected' : '' }}>PKR (Rs.)</option>
                                <option value="USD" {{ $user->preferred_currency === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="EUR" {{ $user->preferred_currency === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="GBP" {{ $user->preferred_currency === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                <option value="INR" {{ $user->preferred_currency === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                <option value="AED" {{ $user->preferred_currency === 'AED' ? 'selected' : '' }}>AED</option>
                                <option value="SAR" {{ $user->preferred_currency === 'SAR' ? 'selected' : '' }}>SAR</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Monthly Allowance Baseline</label>
                            <input type="number" step="100" min="0" name="monthly_allowance_baseline" value="{{ old('monthly_allowance_baseline', $user->monthly_allowance_baseline) }}"
                                   placeholder="e.g. 25000"
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Monthly Savings Goal</label>
                            <input type="number" step="100" min="0" name="monthly_savings_goal" value="{{ old('monthly_savings_goal', $user->monthly_savings_goal) }}"
                                   placeholder="e.g. 5000"
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-lg shadow-blue-600/30">
                            Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Security Form -->
            <div class="glass-panel p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                    <h3 class="text-sm font-bold text-slate-200 uppercase tracking-wider">Change Password</h3>
                </div>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Current Password *</label>
                        <input type="password" name="current_password" required
                               class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none {{ $errors->has('current_password') ? 'border-rose-500' : '' }}">
                        @error('current_password')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">New Password (min 8 chars) *</label>
                            <input type="password" name="password" required
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none {{ $errors->has('password') ? 'border-rose-500' : '' }}">
                            @error('password')
                                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Confirm New Password *</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-3.5 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none {{ $errors->has('password_confirmation') ? 'border-rose-500' : '' }}">
                            @error('password_confirmation')
                                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white text-xs font-semibold">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
