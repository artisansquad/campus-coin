<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use App\Models\InAppNotification;
use App\Models\Insight;
use App\Models\PasswordResetOtp;
use App\Models\SavingTip;
use App\Models\Transaction;
use App\Models\User;
use App\Services\AiCategorizationService;
use App\Services\AiInsightService;
use App\Services\BudgetAlertService;
use App\Services\SavingTipsEngine;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RequirementChecklistTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed default categories
        Category::create(['name' => 'Food', 'type' => 'expense', 'icon' => 'utensils', 'color' => '#EF4444', 'is_default' => true]);
        Category::create(['name' => 'Transport', 'type' => 'expense', 'icon' => 'truck', 'color' => '#F59E0B', 'is_default' => true]);
        Category::create(['name' => 'Allowance', 'type' => 'income', 'icon' => 'wallet', 'color' => '#10B981', 'is_default' => true]);

        // Seed an admin first so newly registered test users are students
        User::create([
            'name' => 'Initial',
            'email' => 'system.admin@campuscoin.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }

    public function test_requirement_01_student_registration_and_login()
    {
        $regData = [
            'name' => 'Sara',
            'last_name' => 'Khan',
            'email' => 'sara@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'academic_year' => '2nd Year',
            'preferred_currency' => 'PKR',
            'monthly_allowance_baseline' => 25000,
            'monthly_savings_goal' => 5000,
        ];

        // Register
        $response = $this->post('/register', $regData);
        $response->assertRedirect('/dashboard.html');
        $this->assertDatabaseHas('users', ['email' => 'sara@example.com']);

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // Login
        $loginRes = $this->post('/login', [
            'email' => 'sara@example.com',
            'password' => 'Password123!',
        ]);
        $loginRes->assertRedirect('/dashboard.html');
        $this->assertAuthenticated();
    }

    public function test_requirement_01_separate_admin_login()
    {
        $admin = User::create([
            'name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@campuscoin.com',
            'password' => Hash::make('AdminPass123!'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@campuscoin.com',
            'password' => 'AdminPass123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_requirement_03_password_reset_flow()
    {
        $student = User::create([
            'name' => 'Hamza',
            'email' => 'hamza@example.com',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'student',
            'status' => 'active',
        ]);

        // Send OTP
        $this->post('/forgot-password', ['email' => 'hamza@example.com']);
        $otpRecord = PasswordResetOtp::where('email', 'hamza@example.com')->first();
        $this->assertNotNull($otpRecord);

        // Reset password
        $resetRes = $this->post('/reset-password', [
            'email' => 'hamza@example.com',
            'otp' => $otpRecord->otp,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $resetRes->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('NewPassword123!', $student->fresh()->password));
    }

    public function test_requirement_04_editable_profile()
    {
        $student = User::create([
            'name' => 'Bilal',
            'email' => 'bilal@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'student',
            'status' => 'active',
            'monthly_allowance_baseline' => 15000,
            'monthly_savings_goal' => 3000,
        ]);

        $this->actingAs($student)->put('/profile', [
            'name' => 'Bilal Updated',
            'email' => 'bilal@example.com',
            'academic_year' => 'Final Year BSCS',
            'preferred_currency' => 'USD',
            'monthly_allowance_baseline' => 35000,
            'monthly_savings_goal' => 8000,
        ]);

        $fresh = $student->fresh();
        $this->assertEquals('Bilal Updated', $fresh->name);
        $this->assertEquals('Final Year BSCS', $fresh->academic_year);
        $this->assertEquals(35000, (float) $fresh->monthly_allowance_baseline);
        $this->assertEquals(8000, (float) $fresh->monthly_savings_goal);
    }

    public function test_requirement_06_and_07_personal_categories_management()
    {
        $student = User::create([
            'name' => 'Zain',
            'email' => 'zain@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'student',
            'status' => 'active',
        ]);

        // Create personal category
        $this->actingAs($student)->post('/categories', [
            'name' => 'Gym & Fitness',
            'type' => 'expense',
            'color' => '#8B5CF6',
        ]);

        $cat = Category::where('name', 'Gym & Fitness')->where('user_id', $student->id)->first();
        $this->assertNotNull($cat);

        // Edit personal category
        $this->actingAs($student)->put("/categories/{$cat->id}", [
            'name' => 'CrossFit & Gym',
            'color' => '#6366F1',
        ]);
        $this->assertEquals('CrossFit & Gym', $cat->fresh()->name);

        // Delete personal category
        $this->actingAs($student)->delete("/categories/{$cat->id}");
        $this->assertNull(Category::find($cat->id));
    }

    public function test_requirement_11_12_13_transaction_crud_and_soft_delete()
    {
        $student = User::create([
            'name' => 'Usman',
            'email' => 'usman@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'student',
            'status' => 'active',
        ]);

        $cat = Category::where('name', 'Food')->first();

        // Log transaction with recurring support
        $this->actingAs($student)->post('/transactions', [
            'description' => 'Hostel Mess Monthly Fee',
            'amount' => 4500,
            'type' => 'expense',
            'category_id' => $cat->id,
            'date' => Carbon::now()->toDateString(),
            'is_recurring' => 1,
            'recurring_frequency' => 'monthly',
        ]);

        $tx = Transaction::where('user_id', $student->id)->first();
        $this->assertNotNull($tx);
        $this->assertTrue($tx->is_recurring);
        $this->assertEquals('monthly', $tx->recurring_frequency);

        // Soft delete retains audit history in database
        $this->actingAs($student)->delete("/transactions/{$tx->id}");
        $this->assertSoftDeleted('transactions', ['id' => $tx->id]);
        $this->assertNotNull(Transaction::withTrashed()->find($tx->id));
    }

    public function test_requirement_14_and_15_ai_categorization_and_learning()
    {
        $student = User::create([
            'name' => 'Ayesha',
            'email' => 'ayesha@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'student',
            'status' => 'active',
        ]);

        $aiService = app(AiCategorizationService::class);

        // Suggests Food for cafe
        $suggested = $aiService->suggest('Campus cafe iced tea and burger', $student->id);
        $this->assertNotNull($suggested);
        $this->assertEquals('Food', $suggested->name);

        // Learn custom association
        $transportCat = Category::where('name', 'Transport')->first();
        $aiService->learn($student->id, 'rickshaw ride home', $transportCat->id);

        $learned = $aiService->suggest('rickshaw', $student->id);
        $this->assertNotNull($learned);
        $this->assertEquals('Transport', $learned->name);
    }

    public function test_requirement_29_30_31_budget_alerts()
    {
        $student = User::create([
            'name' => 'Fahad',
            'email' => 'fahad@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'student',
            'status' => 'active',
        ]);

        $cat = Category::where('name', 'Food')->first();
        $currentMonth = Carbon::now()->format('Y-m');

        // Set budget cap of 2000
        $this->actingAs($student)->post('/budgets', [
            'category_id' => $cat->id,
            'month' => $currentMonth,
            'limit_amount' => 2000,
        ]);

        // Spend 2100 (exceeded)
        $tx = Transaction::create([
            'user_id' => $student->id,
            'category_id' => $cat->id,
            'type' => 'expense',
            'amount' => 2100,
            'date' => Carbon::now()->toDateString(),
            'description' => 'Fine Dining with Friends',
        ]);

        app(BudgetAlertService::class)->checkBudgetAlert($tx);

        $alert = InAppNotification::where('user_id', $student->id)->where('type', 'budget_alert')->first();
        $this->assertNotNull($alert);
        $this->assertStringContainsString('Budget Exceeded: Food', $alert->title);
    }

    public function test_requirement_22_to_25_ai_monthly_insights()
    {
        $student = User::create([
            'name' => 'Danish',
            'email' => 'danish@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'student',
            'status' => 'active',
            'monthly_savings_goal' => 4000,
        ]);

        $cat = Category::where('name', 'Food')->first();
        $incomeCat = Category::where('name', 'Allowance')->first();

        // Income
        Transaction::create([
            'user_id' => $student->id,
            'category_id' => $incomeCat->id,
            'type' => 'income',
            'amount' => 25000,
            'date' => Carbon::now()->toDateString(),
            'description' => 'Allowance from parents',
        ]);

        // Expense
        Transaction::create([
            'user_id' => $student->id,
            'category_id' => $cat->id,
            'type' => 'expense',
            'amount' => 7000,
            'date' => Carbon::now()->toDateString(),
            'description' => 'Canteen food',
        ]);

        $insightService = app(AiInsightService::class);
        $insight = $insightService->generateMonthlyInsight($student);

        $this->assertNotNull($insight);
        $this->assertNotEmpty($insight->summary_text);
        $this->assertStringContainsString('Food', $insight->summary_text);
        $this->assertNotEmpty($insight->tip_text);
    }
}
