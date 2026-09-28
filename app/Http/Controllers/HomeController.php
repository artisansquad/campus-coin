<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTransactions = Transaction::count();

        return view('user.index', compact('totalStudents', 'totalTransactions'));
    }

    public function about(): View
    {
        return view('user.about');
    }

    public function features(): View
    {
        return view('user.features');
    }

    public function faq(): View
    {
        return view('user.faq');
    }

    public function contact(): View
    {
        return view('user.contact');
    }

    public function contactSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return back()->with('success', 'Thank you for reaching out! Our Campus Coin team will reply shortly.');
    }
}
