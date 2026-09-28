<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Coin — Monthly Financial Statement ({{ $selectedMonth }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; font-size: 12pt; }
            .print-border { border: 1px solid #e2e8f0 !important; }
        }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
    </style>
</head>
<body class="p-8 max-w-4xl mx-auto">
    <!-- Print Action Controls -->
    <div class="no-print mb-6 flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <div class="flex items-center gap-2 text-blue-800 text-xs font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Ready for printing or saving as PDF (Press Ctrl+P or click button).</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold shadow">
                Save as PDF / Print
            </button>
            <button onclick="window.close()" class="px-3 py-2 border border-slate-300 hover:bg-slate-100 rounded-lg text-xs font-medium">
                Close
            </button>
        </div>
    </div>

    <!-- Official Statement Header -->
    <div class="border-b-2 border-slate-900 pb-6 mb-6 flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Campus Coin</h1>
            <p class="text-xs text-slate-500 uppercase tracking-widest mt-0.5">Student Financial Management Statement</p>
            <p class="text-xs text-slate-600 mt-2 font-medium">Statement Period: <strong>{{ \Carbon\Carbon::parse($selectedMonth.'-01')->format('F Y') }}</strong></p>
        </div>
        <div class="text-right text-xs text-slate-600">
            <p class="font-bold text-slate-900 text-sm">{{ $user->getFullNameAttribute() }}</p>
            <p>{{ $user->email }}</p>
            <p class="text-[11px] text-slate-500 mt-1">Generated: {{ \Carbon\Carbon::now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>

    <!-- Monthly Financial Totals -->
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
            <span class="text-[11px] uppercase font-bold text-slate-500">Total Inflow</span>
            <p class="text-xl font-bold text-emerald-600 mt-1">{{ $user->currencySymbol() }}{{ number_format($monthlyIncome, 2) }}</p>
        </div>

        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
            <span class="text-[11px] uppercase font-bold text-slate-500">Total Outflow</span>
            <p class="text-xl font-bold text-red-600 mt-1">{{ $user->currencySymbol() }}{{ number_format($monthlyExpense, 2) }}</p>
        </div>

        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
            <span class="text-[11px] uppercase font-bold text-slate-500">Net Surplus / Savings</span>
            <p class="text-xl font-bold {{ ($monthlyIncome - $monthlyExpense) >= 0 ? 'text-blue-600' : 'text-red-600' }} mt-1">
                {{ $user->currencySymbol() }}{{ number_format($monthlyIncome - $monthlyExpense, 2) }}
            </p>
        </div>
    </div>

    <!-- Category Summary Breakdown -->
    <div class="mb-8">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 pb-2 border-b mb-3">Category Spending Breakdown</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
            @forelse($categoryBreakdown as $cb)
                <div class="p-2.5 rounded-lg border border-slate-200 bg-white">
                    <p class="text-slate-500 text-[11px]">{{ $cb->name }}</p>
                    <p class="font-bold font-mono text-slate-900 mt-0.5">{{ $user->currencySymbol() }}{{ number_format($cb->total_amount, 2) }}</p>
                </div>
            @empty
                <p class="text-slate-500 col-span-full">No categorical expenses logged for this month.</p>
            @endforelse
        </div>
    </div>

    <!-- Transactions Itemized Table -->
    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 pb-2 border-b mb-3">Itemized Transaction Records</h3>
        <table class="w-full text-left text-xs border border-slate-200 rounded-lg overflow-hidden">
            <thead class="bg-slate-100 text-slate-600 font-semibold border-b">
                <tr>
                    <th class="py-2.5 px-3">Date</th>
                    <th class="py-2.5 px-3">Description</th>
                    <th class="py-2.5 px-3">Category</th>
                    <th class="py-2.5 px-3">Type</th>
                    <th class="py-2.5 px-3 text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($transactions as $tx)
                    <tr>
                        <td class="py-2 px-3 font-mono text-slate-700">{{ \Carbon\Carbon::parse($tx->date)->format('M d, Y') }}</td>
                        <td class="py-2 px-3 font-medium text-slate-900">{{ $tx->description }}</td>
                        <td class="py-2 px-3 text-slate-600">{{ $tx->category->name ?? '—' }}</td>
                        <td class="py-2 px-3 uppercase text-[10px] font-bold {{ $tx->type === 'income' ? 'text-emerald-600' : 'text-slate-600' }}">{{ $tx->type }}</td>
                        <td class="py-2 px-3 text-right font-mono font-bold {{ $tx->type === 'income' ? 'text-emerald-600' : 'text-slate-900' }}">
                            {{ $tx->type === 'income' ? '+' : '-' }}{{ $user->currencySymbol() }}{{ number_format($tx->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-slate-500">No transactions recorded for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Verification Footer -->
    <div class="mt-12 pt-4 border-t border-slate-300 text-center text-[10px] text-slate-400">
        Campus Coin Student Finance System • Automated Certified Student Statement • Evaluated without real bank transactions
    </div>
</body>
</html>
