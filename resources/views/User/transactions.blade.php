@extends('layouts.app')

@section('title', 'Transactions & Spending Log — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">Transactions</span>
@endsection

@section('content')
<div class="space-y-6" x-data="transactionPage()">
    <!-- Header with Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Transactions & Spending Log</h1>
            <p class="text-xs text-slate-400 mt-1">Manage, filter, and audit your student income and expenditure history.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- CSV Export -->
            <a href="{{ route('transactions.export') }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-700 hover:border-slate-600 bg-slate-800/40 text-slate-300 hover:text-white flex items-center gap-2 transition-all">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export CSV</span>
            </a>

            <!-- Bulk CSV Import Trigger (Requirement 5 & 16) -->
            <button @click="csvModalOpen = true" 
                    class="px-3.5 py-2 rounded-xl text-xs font-semibold border border-blue-500/30 hover:border-blue-500 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span>Import CSV</span>
            </button>

            <!-- Quick Add Button -->
            <button @click="$dispatch('open-quick-add')" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30 flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Entry</span>
            </button>
        </div>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="glass-panel p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium">Total Income Inflow</span>
                <p class="text-xl font-bold text-emerald-400 mt-0.5">{{ $user->currencySymbol() }}{{ number_format($totalIncome, 2) }}</p>
            </div>
        </div>

        <div class="glass-panel p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-500/10 text-red-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium">Total Spending Outflow</span>
                <p class="text-xl font-bold text-red-400 mt-0.5">{{ $user->currencySymbol() }}{{ number_format($totalExpense, 2) }}</p>
            </div>
        </div>

        <div class="glass-panel p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium">Net Student Balance</span>
                <p class="text-xl font-bold {{ $netBalance >= 0 ? 'text-blue-400' : 'text-red-400' }} mt-0.5">
                    {{ $user->currencySymbol() }}{{ number_format($netBalance, 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Filter Bar (Requirement 20) -->
    <div class="glass-panel p-4">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Search -->
            <div>
                <label class="block text-[11px] text-slate-400 mb-1">Search Keyword</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description or note..."
                           class="w-full pl-9 pr-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                    <svg class="w-4 h-4 text-slate-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[11px] text-slate-400 mb-1">Category</label>
                <select name="category_id" class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-[11px] text-slate-400 mb-1">Transaction Type</label>
                <select name="type" class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                    <option value="">Income & Expense</option>
                    <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense Outflows</option>
                    <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Income Inflows</option>
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label class="block text-[11px] text-slate-400 mb-1">Time Horizon</label>
                <div class="flex gap-2">
                    <select name="date_filter" class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                        <option value="">All Time</option>
                        <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ request('date_filter') === 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="last_30_days" {{ request('date_filter') === 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="last_90_days" {{ request('date_filter') === 'last_90_days' ? 'selected' : '' }}>Last 90 Days</option>
                        <option value="this_year" {{ request('date_filter') === 'this_year' ? 'selected' : '' }}>This Year</option>
                    </select>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shrink-0">Filter</button>
                    @if(request()->anyFilled(['search', 'category_id', 'type', 'date_filter']))
                        <a href="{{ route('transactions.index') }}" class="px-3 py-2 rounded-xl border border-slate-700 text-slate-400 hover:text-white text-xs flex items-center justify-center">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Transactions List Table (Requirement 13 & 40) -->
    <div class="glass-panel overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
            <h2 class="text-sm font-bold tracking-tight">Records Log ({{ $transactions->total() }})</h2>
            <span class="text-xs text-slate-400">Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900/70 text-slate-400 uppercase tracking-wider font-semibold border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">AI / Anomaly Tag</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-800/30 transition-colors {{ $tx->is_flagged ? 'bg-amber-500/5' : '' }}">
                            <td class="py-3.5 px-4 font-mono text-slate-300 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($tx->date)->format('M d, Y') }}
                                @if($tx->is_recurring)
                                    <span class="block text-[10px] text-blue-400 uppercase tracking-wide">Recurring ({{ $tx->recurring_frequency }})</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 max-w-xs">
                                <span class="font-medium text-slate-200 block truncate">{{ $tx->description }}</span>
                                @if($tx->notes)
                                    <span class="text-[11px] text-slate-500 block truncate">{{ $tx->notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium"
                                      style="background-color: {{ ($tx->category->color ?? '#3B82F6') }}20; color: {{ $tx->category->color ?? '#3B82F6' }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $tx->category->color ?? '#3B82F6' }}"></span>
                                    <span>{{ $tx->category->name ?? 'Uncategorized' }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($tx->type === 'income')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Inflow</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-red-500/10 text-red-400 border border-red-500/20">Outflow</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-mono font-bold {{ $tx->type === 'income' ? 'text-emerald-400' : 'text-slate-200' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }}{{ $user->currencySymbol() }}{{ number_format($tx->amount, 2) }}
                            </td>
                            <td class="py-3.5 px-4 max-w-xs">
                                @if($tx->is_flagged)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-amber-500/20 text-amber-400 border border-amber-500/30" title="{{ $tx->flag_reason }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span class="truncate">{{ Str::limit($tx->flag_reason, 26) }}</span>
                                    </span>
                                @elseif($tx->aiSuggestedCategory)
                                    <span class="text-[10px] text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded border border-blue-500/20" title="AI match">
                                        AI: {{ $tx->aiSuggestedCategory->name }}
                                    </span>
                                @else
                                    <span class="text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit Trigger (Requirement 13) -->
                                    <button @click="openEditModal(@js($tx))" 
                                            class="p-1 rounded text-slate-400 hover:text-blue-400 hover:bg-slate-800 transition-colors" title="Edit Record">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    <!-- Soft Delete Form (Requirement 13) -->
                                    <form method="POST" action="{{ route('transactions.destroy', $tx) }}" onsubmit="return confirm('Move transaction to trash? Full audit history is retained.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 rounded text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-sm font-semibold">No transactions found</p>
                                <p class="text-xs text-slate-400 mt-1">Start by clicking Quick Log above or import historical data from CSV.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Transaction Modal (Requirement 13 & 15) -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div @click.outside="editModalOpen = false" class="glass-panel w-full max-w-md p-6 border shadow-2xl relative"
             :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
            <div class="flex items-center justify-between pb-3 border-b border-slate-700/50">
                <h3 class="text-base font-bold">Edit Transaction Record</h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>

            <form :action="editFormUrl" method="POST" class="mt-4 space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] text-slate-400 mb-1">Description *</label>
                    <input type="text" name="description" x-model="editingTx.description" required
                           class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[11px] text-slate-400 mb-1">Amount *</label>
                        <input type="number" step="0.01" min="0.01" name="amount" x-model="editingTx.amount" required
                               class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] text-slate-400 mb-1">Type *</label>
                        <select name="type" x-model="editingTx.type" class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                            <option value="expense">Expense</option>
                            <option value="income">Income</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[11px] text-slate-400 mb-1">Date *</label>
                        <input type="date" name="date" x-model="editingTx.date" required
                               class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] text-slate-400 mb-1">Category *</label>
                        <select name="category_id" x-model="editingTx.category_id" required class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] text-slate-400 mb-1">Notes / Tag</label>
                    <textarea name="notes" x-model="editingTx.notes" rows="2" class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs"></textarea>
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="editModalOpen = false" class="px-3 py-1.5 rounded-lg text-xs text-slate-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold">Update Record</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk CSV Import Modal (Requirement 5 & 16) -->
    <div x-show="csvModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div @click.outside="csvModalOpen = false" class="glass-panel w-full max-w-lg p-6 border shadow-2xl relative"
             :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
            <div class="flex items-center justify-between pb-3 border-b border-slate-700/50">
                <h3 class="text-base font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span>Import Historical Transactions (CSV)</span>
                </h3>
                <button @click="csvModalOpen = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="{{ route('transactions.import') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf
                <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800 text-xs space-y-2 text-slate-300">
                    <p class="font-semibold text-blue-400">CSV Guidelines & AI Auto-Categorization:</p>
                    <p>Upload a standard CSV file with headers: <code class="px-1.5 py-0.5 rounded bg-slate-800 font-mono text-emerald-400">Date, Description, Amount, Category, Type</code></p>
                    <p class="text-slate-400 text-[11px]">• If Category is empty, our AI categorization engine will automatically suggest and classify entries based on keywords!</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-2">Select CSV File</label>
                    <input type="file" name="csv_file" accept=".csv,text/csv" required
                           class="w-full px-3 py-2 rounded-xl border bg-slate-900/70 border-slate-700 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-blue-600 file:text-white">
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="csvModalOpen = false" class="px-4 py-2 rounded-xl text-xs text-slate-400">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function transactionPage() {
        return {
            editModalOpen: false,
            csvModalOpen: false,
            editingTx: {},
            editFormUrl: '',

            openEditModal(tx) {
                this.editingTx = { ...tx };
                this.editFormUrl = `{{ url('/transactions') }}/${tx.id}`;
                this.editModalOpen = true;

                // Track recently viewed/edited across session (Requirement 38)
                let recent = JSON.parse(localStorage.getItem('cc_recent_txs') || '[]');
                recent = recent.filter(r => r.id !== tx.id);
                recent.unshift({ id: tx.id, description: tx.description, amount: tx.amount, date: tx.date });
                if (recent.length > 5) recent.pop();
                localStorage.setItem('cc_recent_txs', JSON.stringify(recent));
            }
        };
    }
</script>
@endpush
