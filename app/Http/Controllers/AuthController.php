<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function loginpost(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->status === 'disabled') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your student account has been disabled by an administrator. Please contact support.',
                ]);
            }

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', "Welcome back, Admin {$user->name}!");
            }

            return redirect()->intended(route('dashboard'))->with('success', "Welcome back, {$user->name}!");
        }

        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'The provided credentials do not match our student records.',
        ]);
    }

    public function register(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function RegisterPost(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age' => ['nullable', 'integer', 'min:14', 'max:100'],
            'education' => ['nullable', 'string', 'max:255'],
            'academic_year' => ['nullable', 'string', 'max:255'],
            'preferred_currency' => ['nullable', 'string', 'max:10'],
            'currency' => ['nullable', 'string', 'max:10'],
            'monthly_allowance_baseline' => ['nullable', 'numeric', 'min:0'],
            'monthly_saving_goal' => ['nullable', 'numeric', 'min:0'],
            'monthly_savings_goal' => ['nullable', 'numeric', 'min:0'],
        ]);

        $isFirstUser = User::query()->count() === 0;

        $user = User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'] ?? null,
            'email' => $validated['email'],
            'password' => $validated['password'], // hashed by cast
            'role' => $isFirstUser ? 'admin' : 'student',
            'student_id' => $isFirstUser ? null : ('STU-' . date('Y') . '-' . str_pad((string)(User::max('id') + 1), 3, '0', STR_PAD_LEFT)),
            'status' => 'active',
            'age' => $validated['age'] ?? null,
            'academic_year' => $validated['academic_year'] ?? $validated['education'] ?? 'Undergraduate',
            'preferred_currency' => $validated['preferred_currency'] ?? $validated['currency'] ?? 'PKR',
            'monthly_allowance_baseline' => $validated['monthly_allowance_baseline'] ?? 0,
            'monthly_savings_goal' => $validated['monthly_savings_goal'] ?? $validated['monthly_saving_goal'] ?? 0,
        ]);

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', "Welcome to Campus Coin, Admin {$user->name}! Your admin portal is ready.");
        }

        return redirect()->route('dashboard')->with('success', "Welcome to Campus Coin, {$user->name}! Your smart financial journey begins now.");
    }

    public function adminLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }

        return view('auth.login', ['isAdminLogin' => true]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been safely logged out.');
    }

    public function sessionCheck(Request $request): \Illuminate\Http\JsonResponse
    {
        $isAuthenticated = Auth::check();
        $user = Auth::user();

        return response()->json([
            'authenticated' => $isAuthenticated,
            'user' => $isAuthenticated ? [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ] : null,
            'session_lifetime_seconds' => config('session.lifetime', 120) * 60,
        ]);
    }
}
