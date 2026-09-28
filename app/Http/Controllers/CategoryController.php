<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $defaultIncomeCategories = Category::whereNull('user_id')->income()->get();
        $defaultExpenseCategories = Category::whereNull('user_id')->expense()->get();

        $customIncomeCategories = Category::where('user_id', $user->id)->income()->get();
        $customExpenseCategories = Category::where('user_id', $user->id)->expense()->get();

        return view('user.categories', compact(
            'user',
            'defaultIncomeCategories',
            'defaultExpenseCategories',
            'customIncomeCategories',
            'customExpenseCategories'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'type' => ['required', 'in:income,expense'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        Category::create([
            'user_id' => $user->id,
            'name' => trim($validated['name']),
            'type' => $validated['type'],
            'icon' => $validated['icon'] ?? ($validated['type'] === 'income' ? 'wallet' : 'tag'),
            'color' => $validated['color'] ?? ($validated['type'] === 'income' ? '#10B981' : '#3B82F6'),
            'is_default' => false,
        ]);

        return back()->with('success', "Custom category '{$validated['name']}' created successfully!");
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $user = Auth::user();
        if ($category->user_id !== $user->id) {
            abort(403, 'You can only modify your own custom categories.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $category->update($validated);

        return back()->with('success', "Category '{$category->name}' updated successfully!");
    }

    public function destroy(Category $category): RedirectResponse
    {
        $user = Auth::user();
        if ($category->user_id !== $user->id) {
            abort(403, 'System default categories cannot be deleted by students.');
        }

        $name = $category->name;
        $category->delete();

        return back()->with('success', "Category '{$name}' deleted.");
    }
}
