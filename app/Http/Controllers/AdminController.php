<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\InAppNotification;
use App\Models\SavingTip;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        // 1. Overall System Usage Statistics
        $totalStudents = User::where('role', 'student')->count();
        $activeStudentsCount = User::where('role', 'student')->where('status', 'active')->count();
        $totalTransactionsCount = Transaction::count();
        $totalVolume = (float) Transaction::sum('amount');

        // Transactions logged this month
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $thisMonthTransactions = Transaction::where('date', '>=', $startOfMonth)->count();

        // 2. Most-used Categories
        $mostUsedCategories = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.type', 'categories.color', DB::raw('COUNT(transactions.id) as tx_count'), DB::raw('SUM(transactions.amount) as total_volume'))
            ->groupBy('categories.id', 'categories.name', 'categories.type', 'categories.color')
            ->orderByDesc('tx_count')
            ->take(5)
            ->get();

        // 3. Default System Categories
        $defaultCategories = Category::whereNull('user_id')->orderBy('type')->orderBy('name')->get();

        // 4. System-wide Tip Templates & Announcements
        $systemTips = SavingTip::whereNull('user_id')->latest()->get();

        // 5. User Accounts list
        $students = User::where('role', 'student')->withCount('transactions')->latest()->paginate(10);

        $studentRows = $students->getCollection()->map(function (User $student): array {
            $fullName = trim("{$student->name} {$student->last_name}");
            $initials = collect(preg_split('/\s+/', $fullName ?: $student->name ?: 'U'))
                ->filter()
                ->map(fn (string $part): string => strtoupper(mb_substr($part, 0, 1)))
                ->take(2)
                ->implode('');

            return [
                'id' => $student->id,
                'name' => $fullName ?: $student->name,
                'first_name' => $student->name,
                'last_name' => $student->last_name ?? '',
                'email' => $student->email,
                'student_id' => $student->student_id ?? ('STU-' . str_pad($student->id, 4, '0', STR_PAD_LEFT)),
                'age' => $student->age,
                'academic_year' => $student->academic_year ?? 'Undergraduate',
                'preferred_currency' => $student->preferred_currency ?? 'PKR',
                'currency_symbol' => $student->currencySymbol(),
                'monthly_allowance_baseline' => (float) $student->monthly_allowance_baseline,
                'monthly_savings_goal' => (float) $student->monthly_savings_goal,
                'joined' => $student->created_at?->format('M d, Y') ?? '—',
                'status' => strtolower($student->status ?? 'active'),
                'goals' => (int) $student->goals()->count(),
                'transactions' => (int) $student->transactions_count,
                'total_volume' => (float) $student->transactions()->sum('amount'),
                'role' => strtolower($student->role),
                'initials' => $initials ?: 'ST',
                'color' => $student->id % 2 === 0
                    ? 'linear-gradient(135deg, #3B82F6, #60A5FA)'
                    : 'linear-gradient(135deg, #8B5CF6, #A78BFA)',
            ];
        })->values()->all();

        $dashboardStats = [
            'users' => (int) $totalStudents,
            'transactions' => (int) $totalTransactionsCount,
            'goals' => (int) $activeStudentsCount,
            'revenue' => (int) round((float) $totalVolume),
            'savings' => (int) $thisMonthTransactions,
            'ratio' => $totalStudents > 0 ? (int) round(($activeStudentsCount / $totalStudents) * 100) : 0,
        ];

        $monthlyTransactions = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Transaction::whereBetween('date', [
                $month->copy()->startOfMonth()->toDateString(),
                $month->copy()->endOfMonth()->toDateString(),
            ])->count();

            $monthlyTransactions->push([
                'label' => $month->translatedFormat('M'),
                'value' => $count,
            ]);
        }

        $recentUsersThisWeek = User::where('role', 'student')->where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $budgetAlerts = User::where('role', 'student')->where('status', 'active')->count();
        $recentGoals = User::where('role', 'student')->whereNotNull('monthly_savings_goal')->count();
        $recentAiRequests = Transaction::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        $activityIcons = [
            'bg-blue-500/10 text-blue-300',
            'bg-amber-500/10 text-amber-300',
            'bg-emerald-500/10 text-emerald-300',
            'bg-violet-500/10 text-violet-300',
        ];

        $recentActivities = [
            [
                'title' => 'New student onboarding',
                'time' => 'This week',
                'value' => '+'.$recentUsersThisWeek,
                'bg' => $activityIcons[0],
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>',
            ],
            [
                'title' => 'Budget alert triggered',
                'time' => 'This month',
                'value' => $budgetAlerts.' users',
                'bg' => $activityIcons[1],
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3m0 3h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>',
            ],
            [
                'title' => 'Goal milestone reached',
                'time' => 'This week',
                'value' => '+'.$recentGoals,
                'bg' => $activityIcons[2],
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 3"/></svg>',
            ],
            [
                'title' => 'AI tutoring request',
                'time' => 'This week',
                'value' => $recentAiRequests.' chats',
                'bg' => $activityIcons[3],
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5M7 4h10a2 2 0 012 2v12l-4-3H7a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>',
            ],
        ];

        $systemStatus = [
            ['name' => 'API', 'status' => '99.9%', 'detail' => 'Stable uptime'],
            ['name' => 'DB', 'status' => '98.5%', 'detail' => 'No issues'],
            ['name' => 'AI', 'status' => '94.8%', 'detail' => 'Low latency'],
        ];

        $categoryData = Category::whereNull('user_id')->withCount('transactions')->orderBy('name')->get()->map(function (Category $category): array {
            $emojiMap = [
                'food' => '🍽',
                'transport' => '🚇',
                'rent' => '🏠',
                'housing' => '🏠',
                'hostel' => '🏠',
                'entertainment' => '🎉',
                'scholarship' => '🎓',
                'job' => '💼',
                'gift' => '🎁',
                'allowance' => '💰',
                'other income' => '📈',
                'miscellaneous' => '🧩',
            ];

            $nameLower = strtolower($category->name);
            $icon = $emojiMap[$nameLower] ?? '📌';
            $percent = $category->transactions_count > 0 ? min(100, (int) round(($category->transactions_count / max(1, Transaction::count())) * 100)) : 0;

            return [
                'id' => (int) $category->id,
                'name' => $category->name,
                'icon' => $icon,
                'bg' => 'linear-gradient(135deg, rgba(59,130,246,.18), rgba(59,130,246,.08))',
                'color' => $category->color ?? '#60A5FA',
                'transactions' => (int) $category->transactions_count,
                'percent' => $percent,
                'type' => $category->type,
            ];
        })->values()->all();

        $expenseCategories = array_values(array_filter($categoryData, fn (array $item): bool => ($item['type'] ?? 'expense') === 'expense'));
        $incomeCategories = array_values(array_filter($categoryData, fn (array $item): bool => ($item['type'] ?? 'income') === 'income'));

        $analyticsSnapshot = \App\Models\PlatformAnalytics::forPeriod('12m');
        $analyticStats = [
            $analyticsSnapshot['growth_rate'] ?? null,
            $analyticsSnapshot['savings'] ?? null,
            $analyticsSnapshot['conversion'] ?? null,
            $analyticsSnapshot['retention'] ?? null,
        ];

        $dashboardPanelData = [
            'stats' => [
                ['key' => 'users', 'label' => 'Total Users', 'prefix' => '', 'suffix' => '', 'change' => '+12.4%', 'value' => $dashboardStats['users'], 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm13 10v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>', 'bg' => 'bg-blue-500/10 text-blue-400'],
                ['key' => 'transactions', 'label' => 'Transactions', 'prefix' => '', 'suffix' => '', 'change' => '+8.6%', 'value' => $dashboardStats['transactions'], 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h10M7 5h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>', 'bg' => 'bg-cyan-500/10 text-cyan-400'],
                ['key' => 'goals', 'label' => 'Goals', 'prefix' => '', 'suffix' => '%', 'change' => '+4.1%', 'value' => $dashboardStats['goals'], 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7H14.5a3.5 3.5 0 010 7H6"/></svg>', 'bg' => 'bg-violet-500/10 text-violet-400'],
                ['key' => 'revenue', 'label' => 'Savings', 'prefix' => '$', 'suffix' => '', 'change' => '+15.2%', 'value' => $dashboardStats['revenue'], 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7H14.5a3.5 3.5 0 010 7H6"/></svg>', 'bg' => 'bg-emerald-500/10 text-emerald-400'],
                ['key' => 'savings', 'label' => 'Active Users', 'prefix' => '', 'suffix' => '', 'change' => '+10.8%', 'value' => $activeStudentsCount, 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2l2.5 6.5L21 11l-6.5 2.5L12 20l-2.5-6.5L3 11l6.5-2.5L12 2z"/></svg>', 'bg' => 'bg-amber-500/10 text-amber-400'],
                ['key' => 'ratio', 'label' => 'Engagement', 'prefix' => '', 'suffix' => '%', 'change' => '+2.7%', 'value' => $dashboardStats['ratio'], 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 15l4-4 3 3 7-7 2 2v9H4z"/></svg>', 'bg' => 'bg-pink-500/10 text-pink-400'],
            ],
            'analyticsStats' => array_filter($analyticStats),
            'users' => $studentRows,
            'expenseCategories' => $expenseCategories,
            'incomeCategories' => $incomeCategories,
            'systems' => $systemStatus,
            'activities' => $recentActivities,
            'transactionBars' => $monthlyTransactions->pluck('value')->values()->all(),
            'transactionMonths' => $monthlyTransactions->pluck('label')->values()->all(),
        ];

        $adminNotifications = InAppNotification::where('user_id', auth()->id())
            ->latest()
            ->limit(20)
            ->get()
            ->map(function (InAppNotification $notification): array {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'sender_name' => $notification->sender_name,
                    'sender_email' => $notification->sender_email,
                    'is_read' => (bool) $notification->is_read,
                    'created_at' => $notification->created_at?->toISOString(),
                ];
            })
            ->values()
            ->all();

        return view('Admin.admin-dashboard', compact(
            'totalStudents',
            'activeStudentsCount',
            'totalTransactionsCount',
            'totalVolume',
            'thisMonthTransactions',
            'mostUsedCategories',
            'defaultCategories',
            'systemTips',
            'students',
            'studentRows',
            'dashboardStats',
            'dashboardPanelData',
            'adminNotifications'
        ));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'type' => ['required', 'in:income,expense'],
            'color' => ['nullable', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        Category::create([
            'user_id' => null, // Default system category
            'name' => trim($validated['name']),
            'type' => $validated['type'],
            'color' => $validated['color'] ?? ($validated['type'] === 'income' ? '#10B981' : '#3B82F6'),
            'icon' => $validated['icon'] ?? 'tag',
            'is_default' => true,
        ]);

        return back()->with('success', "System default category '{$validated['name']}' added!");
    }

    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $category->update($validated);

        return back()->with('success', "Category '{$category->name}' updated!");
    }

    public function destroyCategory(Category $category): RedirectResponse
    {
        // Prevent deletion of categories with active transactions
        if ($category->transactions()->count() > 0) {
            return back()->withErrors([
                'error' => "Cannot delete '{$category->name}' - it has {$category->transactions()->count()} transaction(s). Please reassign or remove transactions first.",
            ]);
        }

        // Only allow deletion of default (system) categories
        if ($category->user_id !== null) {
            return back()->withErrors([
                'error' => "Cannot delete user-created category '{$category->name}'. Only system categories can be deleted by admins.",
            ]);
        }

        $name = $category->name;
        $category->delete();

        return back()->with('success', "Category '{$name}' has been deleted from system defaults.");
    }

    public function storeTip(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:1000'],
            'category' => ['nullable', 'string', 'max:50'],
            'impact_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        SavingTip::create([
            'user_id' => null, // System-wide template / announcement
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'] ?? 'General',
            'impact_amount' => $validated['impact_amount'] ?? null,
            'is_pinned' => true,
        ]);

        return back()->with('success', 'System-wide tip / announcement posted to all students!');
    }

    public function destroyTip(SavingTip $tip): RedirectResponse
    {
        $tip->delete();

        return back()->with('success', 'Tip template removed.');
    }

    public function toggleUserStatus(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Cannot disable an administrator account.']);
        }

        $user->status = ($user->status === 'active') ? 'disabled' : 'active';
        $user->save();

        $action = $user->status === 'active' ? 'activated' : 'disabled';

        return back()->with('success', "Student account {$user->name} has been {$action}.");
    }

    public function resetUserPassword(User $user): RedirectResponse
    {
        $defaultPassword = 'Password123!';
        $user->password = $defaultPassword;
        $user->save();

        return back()->with('success', "Password for {$user->name} has been reset to: {$defaultPassword}");
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'student_id' => ['nullable', 'string', 'max:50', 'unique:users,student_id,' . $user->id],
            'role' => ['required', 'string', 'in:student,admin'],
            'status' => ['required', 'string', 'in:active,disabled'],
            'age' => ['nullable', 'integer', 'min:10', 'max:120'],
            'academic_year' => ['nullable', 'string', 'max:255'],
            'preferred_currency' => ['nullable', 'string', 'max:10'],
            'monthly_allowance_baseline' => ['nullable', 'numeric', 'min:0'],
            'monthly_savings_goal' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'] ?? null,
            'email' => $validated['email'],
            'student_id' => $validated['student_id'] ?? $user->student_id,
            'role' => $validated['role'],
            'status' => $validated['status'],
            'age' => $validated['age'] ?? null,
            'academic_year' => $validated['academic_year'] ?? null,
            'preferred_currency' => $validated['preferred_currency'] ?? 'PKR',
            'monthly_allowance_baseline' => $validated['monthly_allowance_baseline'] ?? 0,
            'monthly_savings_goal' => $validated['monthly_savings_goal'] ?? 0,
        ]);

        return back()->with('success', "User details for {$user->name} have been successfully updated!");
    }
}
