<?php

namespace Database\Seeders;

use App\Models\AiLearning;
use App\Models\Budget;
use App\Models\Category;
use App\Models\InAppNotification;
use App\Models\Insight;
use App\Models\SavingTip;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Categories as specified in SRS (Page 7)
        $defaultCategories = [
            // Income Categories
            ['name' => 'Allowance', 'type' => 'income', 'icon' => 'wallet', 'color' => '#10B981'],
            ['name' => 'Part-time Job', 'type' => 'income', 'icon' => 'briefcase', 'color' => '#3B82F6'],
            ['name' => 'Scholarship', 'type' => 'income', 'icon' => 'academic-cap', 'color' => '#8B5CF6'],
            ['name' => 'Gift', 'type' => 'income', 'icon' => 'gift', 'color' => '#EC4899'],
            ['name' => 'Other Income', 'type' => 'income', 'icon' => 'banknotes', 'color' => '#14B8A6'],

            // Expense Categories
            ['name' => 'Food', 'type' => 'expense', 'icon' => 'utensils', 'color' => '#EF4444'],
            ['name' => 'Transport', 'type' => 'expense', 'icon' => 'truck', 'color' => '#F59E0B'],
            ['name' => 'Hostel/Rent', 'type' => 'expense', 'icon' => 'home', 'color' => '#6366F1'],
            ['name' => 'Academics', 'type' => 'expense', 'icon' => 'book-open', 'color' => '#06B6D4'],
            ['name' => 'Subscriptions', 'type' => 'expense', 'icon' => 'device-phone-mobile', 'color' => '#84CC16'],
            ['name' => 'Entertainment', 'type' => 'expense', 'icon' => 'film', 'color' => '#A855F7'],
            ['name' => 'Miscellaneous', 'type' => 'expense', 'icon' => 'ellipsis-horizontal', 'color' => '#64748B'],
        ];

        $categoriesMap = [];
        foreach ($defaultCategories as $cat) {
            $created = Category::firstOrCreate(
                ['name' => $cat['name'], 'user_id' => null],
                [
                    'type' => $cat['type'],
                    'icon' => $cat['icon'],
                    'color' => $cat['color'],
                    'is_default' => true,
                ]
            );
            $categoriesMap[$cat['name']] = $created;
        }

        // 2. Create Administrator User
        $admin = User::firstOrCreate(
            ['email' => 'admin@campuscoin.com'],
            [
                'name' => 'Campus',
                'last_name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'preferred_currency' => 'PKR',
                'academic_year' => 'Administrator',
            ]
        );

        $admin->update([
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 3. Create Demo Student User
        $student = User::firstOrCreate(
            ['email' => 'student@campuscoin.com'],
            [
                'name' => 'Ali',
                'last_name' => 'Raza',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'status' => 'active',
                'age' => 21,
                'academic_year' => '3rd Year / Computer Science',
                'preferred_currency' => 'PKR',
                'student_id' => 'STU-2026-001',
                'monthly_allowance_baseline' => 30000,
                'monthly_savings_goal' => 6000,
            ]
        );

        $student->update([
            'student_id' => $student->student_id ?: 'STU-2026-001',
        ]);

        // 4. Create 6 Months of Realistic Historical Transactions for Demo Student
        $now = Carbon::now();
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = $now->copy()->subMonths($i);
            $yearMonth = $monthDate->format('Y-m');

            // Monthly Allowance on 1st of month
            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Allowance']->id,
                'type' => 'income',
                'amount' => 25000,
                'date' => $monthDate->copy()->startOfMonth()->addDays(1)->toDateString(),
                'description' => 'Monthly allowance from parents',
                'is_recurring' => true,
                'recurring_frequency' => 'monthly',
                'notes' => 'Direct transfer',
            ]);

            // Occasional freelance / part-time or scholarship
            if ($i % 2 === 0) {
                Transaction::create([
                    'user_id' => $student->id,
                    'category_id' => $categoriesMap['Part-time Job']->id,
                    'type' => 'income',
                    'amount' => 12000,
                    'date' => $monthDate->copy()->startOfMonth()->addDays(12)->toDateString(),
                    'description' => 'Freelance React web development gig',
                    'notes' => 'Client payment',
                ]);
            }

            // Fixed Hostel/Rent on 3rd of month
            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Hostel/Rent']->id,
                'type' => 'expense',
                'amount' => 9000,
                'date' => $monthDate->copy()->startOfMonth()->addDays(3)->toDateString(),
                'description' => 'Hostel room fee & utility share',
                'is_recurring' => true,
                'recurring_frequency' => 'monthly',
            ]);

            // Food & Canteen expenses
            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Food']->id,
                'type' => 'expense',
                'amount' => 1850,
                'date' => $monthDate->copy()->startOfMonth()->addDays(5)->toDateString(),
                'description' => 'Campus Cafe lunch & snacks',
            ]);

            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Food']->id,
                'type' => 'expense',
                'amount' => 2400,
                'date' => $monthDate->copy()->startOfMonth()->addDays(14)->toDateString(),
                'description' => 'Hostel canteen dinner & chai',
            ]);

            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Food']->id,
                'type' => 'expense',
                'amount' => 1650,
                'date' => $monthDate->copy()->startOfMonth()->addDays(23)->toDateString(),
                'description' => 'Subway meal with study group',
            ]);

            // Transport (Metro, Bus, Careem)
            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Transport']->id,
                'type' => 'expense',
                'amount' => 2200,
                'date' => $monthDate->copy()->startOfMonth()->addDays(4)->toDateString(),
                'description' => 'Metro transit student monthly pass',
                'is_recurring' => true,
                'recurring_frequency' => 'monthly',
            ]);

            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Transport']->id,
                'type' => 'expense',
                'amount' => 750,
                'date' => $monthDate->copy()->startOfMonth()->addDays(18)->toDateString(),
                'description' => 'Careem ride to examination hall',
            ]);

            // Academics (books, stationery, photocopies)
            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Academics']->id,
                'type' => 'expense',
                'amount' => 1400,
                'date' => $monthDate->copy()->startOfMonth()->addDays(7)->toDateString(),
                'description' => 'Reference books & assignment printouts',
            ]);

            // Subscriptions
            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Subscriptions']->id,
                'type' => 'expense',
                'amount' => 800,
                'date' => $monthDate->copy()->startOfMonth()->addDays(10)->toDateString(),
                'description' => 'Spotify & ChatGPT Student subscription',
                'is_recurring' => true,
                'recurring_frequency' => 'monthly',
            ]);

            // Entertainment
            Transaction::create([
                'user_id' => $student->id,
                'category_id' => $categoriesMap['Entertainment']->id,
                'type' => 'expense',
                'amount' => 1500,
                'date' => $monthDate->copy()->startOfMonth()->addDays(20)->toDateString(),
                'description' => 'Weekend cinema tickets & popcorn',
            ]);

            // Generate Pre-stored Insight for each month
            Insight::create([
                'user_id' => $student->id,
                'month' => $yearMonth,
                'summary_text' => 'In '.$monthDate->format('F Y').', you managed your campus finances reliably. Highest spend was recorded in Hostel/Rent and Campus Dining.',
                'flagged_category' => 'Food',
                'growth_percentage' => 18.5,
                'tip_text' => 'Tip: Keeping weekend dining in check can help you save an additional Rs. 2,000 every month.',
                'is_bookmarked' => $i === 0,
                'generated_at' => $monthDate->copy()->endOfMonth(),
            ]);
        }

        // 5. Create Monthly Category Budgets for Current Month
        $currentMonth = $now->format('Y-m');
        $budgetsConfig = [
            'Food' => 8000,
            'Transport' => 3500,
            'Academics' => 4000,
            'Entertainment' => 3000,
            'Subscriptions' => 1500,
        ];

        foreach ($budgetsConfig as $catName => $limit) {
            Budget::firstOrCreate(
                [
                    'user_id' => $student->id,
                    'category_id' => $categoriesMap[$catName]->id,
                    'month' => $currentMonth,
                ],
                [
                    'limit_amount' => $limit,
                ]
            );
        }

        // 6. Create System-wide and Personalized Saving Tips
        SavingTip::create([
            'user_id' => null, // System template
            'title' => 'Student ID Discounts on Software & Transport',
            'description' => 'Always present your university student ID card when buying regional train/bus passes, museum entries, and software licenses (GitHub Student Pack gives free domain & hosting!).',
            'impact_amount' => 4500,
            'category' => 'General',
            'is_pinned' => true,
        ]);

        SavingTip::create([
            'user_id' => null, // System template
            'title' => 'Hostel Bulk Grocery & Mess Sharing',
            'description' => 'Buying daily staples (milk, eggs, fruit) in bulk with your hostel roommates reduces weekly snacking costs by over 30%.',
            'impact_amount' => 2500,
            'category' => 'Food',
            'is_pinned' => false,
        ]);

        SavingTip::create([
            'user_id' => $student->id,
            'title' => 'Optimize Campus Dining & Takeout',
            'description' => 'You spent Rs. 5,900 on food this month. Preparing snacks in the dorm two nights a week can save Rs. 1,500 towards your goal.',
            'impact_amount' => 1500,
            'category' => 'Food',
            'is_pinned' => true,
            'is_bookmarked' => true,
        ]);

        // 7. Seed AI Learned Keyword Associations
        $aiKeywords = [
            ['cafe', 'Food'],
            ['canteen', 'Food'],
            ['subway', 'Food'],
            ['mess', 'Food'],
            ['metro', 'Transport'],
            ['bus', 'Transport'],
            ['careem', 'Transport'],
            ['uber', 'Transport'],
            ['photocopy', 'Academics'],
            ['books', 'Academics'],
            ['netflix', 'Subscriptions'],
            ['spotify', 'Subscriptions'],
            ['cinema', 'Entertainment'],
            ['hostel', 'Hostel/Rent'],
            ['allowance', 'Allowance'],
            ['freelance', 'Part-time Job'],
        ];

        foreach ($aiKeywords as [$keyword, $categoryName]) {
            if (isset($categoriesMap[$categoryName])) {
                AiLearning::firstOrCreate(
                    ['keyword' => $keyword, 'user_id' => null],
                    [
                        'category_id' => $categoriesMap[$categoryName]->id,
                        'confidence' => 1.0,
                    ]
                );
            }
        }

        // 8. Create In-App Notifications for Demo Student
        InAppNotification::create([
            'user_id' => $student->id,
            'title' => 'Welcome to Campus Coin!',
            'message' => 'Your student financial dashboard is all set up. You can track canteen expenses, budget hostel fees, and review AI insights anytime.',
            'type' => 'system',
            'is_read' => false,
        ]);

        InAppNotification::create([
            'user_id' => $student->id,
            'title' => 'Budget Alert: Food at 73%',
            'message' => 'You have spent Rs. 5,900 of your Rs. 8,000 food budget for this month.',
            'type' => 'warning',
            'is_read' => false,
        ]);
    }
}
