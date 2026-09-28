<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'age' => ['nullable', 'integer', 'min:14', 'max:100'],
            'academic_year' => ['nullable', 'string', 'max:100'],
            'preferred_currency' => ['required', 'string', 'max:10'],
            'monthly_allowance_baseline' => ['nullable', 'numeric', 'min:0'],
            'monthly_savings_goal' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile information updated successfully!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (! Hash::check($value, $user->password)) {
                    $fail('Current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}
