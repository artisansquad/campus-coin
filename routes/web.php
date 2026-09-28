<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiCoachController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\PlatformAnalyticsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public & Landing Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about.html', [HomeController::class, 'about'])->name('about');
Route::get('/features.html', [HomeController::class, 'features'])->name('features');
Route::get('/faq.html', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact.html', [HomeController::class, 'contact'])->name('contact');
Route::redirect('/index.html', '/');
Route::redirect('/ai.coach.html', '/ai-coach.html');
Route::post('/contact.html', [ContactMessageController::class, 'store'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login.html', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginpost'])->name('login.post');
    Route::post('/loginpost', [AuthController::class, 'loginpost']); // legacy support

    Route::get('/register.html', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'RegisterPost'])->name('register.post');
    Route::post('/RegisterPost', [AuthController::class, 'RegisterPost']); // legacy support

  
    Route::get('/reset-password/{token?}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
;

    Route::get('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/api/session-check', [AuthController::class, 'sessionCheck'])->name('session.check');

/*
|--------------------------------------------------------------------------
| Student Protected Routes (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard.html', [DashboardController::class, 'index'])->name('dashboard');

    // Goals (Full CRUD + Savings Progress + Deposits/Withdrawals)
    Route::get('/goals.html', [GoalController::class, 'index'])->name('goals.index');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
    Route::put('/goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
    Route::post('/goals/{goal}/deposit', [GoalController::class, 'deposit'])->name('goals.deposit');
    Route::post('/goals/{goal}/withdraw', [GoalController::class, 'withdraw'])->name('goals.withdraw');

    // Transactions (CRUD + CSV + AI live endpoint)
    Route::get('/transactions.html', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::post('/transactions/import-csv', [TransactionController::class, 'importCsv'])->name('transactions.import');
    Route::get('/transactions/export-csv.html', [TransactionController::class, 'exportCsv'])->name('transactions.export');
    Route::get('/api/ai/suggest-category.html', [TransactionController::class, 'suggestCategory'])->name('api.ai.suggest');

    // Category Management (Manage Own Categories)
    Route::get('/categories.html', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('user.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('user.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('user.categories.destroy');

    // Monthly Budgets
    Route::get('/budgets.html', [BudgetController::class, 'index'])->name('budgets.index');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

    // Monthly Reports & PDF Export
    Route::get('/reports.html', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf.html', [ReportController::class, 'exportPdf'])->name('reports.pdf');

    // AI Spending Insights & Saving Tips
    Route::get('/insights.html', [InsightController::class, 'index'])->name('insights.index');
    Route::post('/insights/generate', [InsightController::class, 'generate'])->name('insights.generate');
    Route::post('/insights/{insight}/bookmark', [InsightController::class, 'toggleBookmark'])->name('insights.bookmark');
    Route::post('/tips/{tip}/bookmark', [InsightController::class, 'toggleTipBookmark'])->name('tips.bookmark');
    Route::post('/tips/{tip}/dismiss', [InsightController::class, 'dismissTip'])->name('tips.dismiss');
    Route::post('/tips/{tip}/pin', [InsightController::class, 'togglePinTip'])->name('tips.pin');

    // AI Coach / Financial Chatbot
    Route::get('/ai-coach.html', [AiCoachController::class, 'index'])->name('ai.coach');
    Route::post('/ai-coach/chat', [AiCoachController::class, 'chat'])->name('ai.coach.chat');

    // User Profile & Password
    Route::get('/profile.html', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // In-app Notifications
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

/*
|--------------------------------------------------------------------------
| Admin Control Panel Routes (Auth & Admin Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [PlatformAnalyticsController::class, 'index'])->name('analytics.index');
    Route::post('/analytics/refresh', [PlatformAnalyticsController::class, 'refresh'])->name('analytics.refresh');

    // Default categories management
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // System-wide announcements & tip templates
    Route::post('/tips', [AdminController::class, 'storeTip'])->name('tips.store');
    Route::delete('/tips/{tip}', [AdminController::class, 'destroyTip'])->name('tips.destroy');

    // User accounts management
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
    Route::post('/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.resetPassword');
});



Route::get('/forgot-password.html', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])
    ->name('password.otp');

Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showVerifyForm'])
    ->name('password.verify.form');

Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('password.verify');

Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');