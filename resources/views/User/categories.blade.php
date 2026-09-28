@extends('layouts.app')

@section('title', 'Manage Own Categories — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">Categories</span>
@endsection

@section('content')
<div class="space-y-6" x-data="categoryManager()">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Manage Categories</h1>
            <p class="text-xs text-slate-400 mt-1">Personalize your student spending buckets. Create custom categories or inspect system defaults.</p>
        </div>

        <button @click="createModalOpen = true" 
                class="px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30 flex items-center gap-2 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Create Custom Category</span>
        </button>
    </div>

    <!-- Student's Personal Categories Section (Requirement 6 & 7) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <span>My Custom Categories</span>
            </h2>
            <span class="text-xs text-slate-400 font-medium">Editable by you</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Custom Expense Categories -->
            <div class="glass-panel p-5 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-red-400">Custom Expenses ({{ $customExpenseCategories->count() }})</h3>
                </div>

                @forelse($customExpenseCategories as $cat)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold"
                                 style="background-color: {{ $cat->color }}25; color: {{ $cat->color }};">
                                ●
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-200">{{ $cat->name }}</p>
                                <span class="text-[10px] text-slate-400">{{ $cat->transactions()->count() }} transactions logged</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1">
                            <button @click="openEditModal(@js($cat))" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-slate-800 transition-colors" title="Edit Category">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('user.categories.destroy', $cat) }}" onsubmit="return confirm('Delete this personal category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-xs text-slate-500">
                        No custom expense categories created yet. Click "Create Custom Category" above!
                    </div>
                @endforelse
            </div>

            <!-- Custom Income Categories -->
            <div class="glass-panel p-5 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-400">Custom Incomes ({{ $customIncomeCategories->count() }})</h3>
                </div>

                @forelse($customIncomeCategories as $cat)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold"
                                 style="background-color: {{ $cat->color }}25; color: {{ $cat->color }};">
                                ●
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-200">{{ $cat->name }}</p>
                                <span class="text-[10px] text-slate-400">{{ $cat->transactions()->count() }} transactions logged</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1">
                            <button @click="openEditModal(@js($cat))" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-slate-800 transition-colors" title="Edit Category">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('user.categories.destroy', $cat) }}" onsubmit="return confirm('Delete this personal category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-xs text-slate-500">
                        No custom income categories created yet. (e.g. Freelance Gigs, Campus Tutoring)
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- System Default Categories Section -->
    <div class="space-y-4 pt-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                <span>System Default Categories</span>
            </h2>
            <span class="text-xs text-slate-400">Available to all students</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            @foreach($defaultExpenseCategories as $def)
                <div class="glass-panel p-3.5 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs"
                         style="background-color: {{ $def->color }}20; color: {{ $def->color }};">
                        ●
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-200">{{ $def->name }}</p>
                        <span class="text-[10px] text-slate-400 uppercase">Expense Default</span>
                    </div>
                </div>
            @endforeach

            @foreach($defaultIncomeCategories as $def)
                <div class="glass-panel p-3.5 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs"
                         style="background-color: {{ $def->color }}20; color: {{ $def->color }};">
                        ●
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-200">{{ $def->name }}</p>
                        <span class="text-[10px] text-emerald-400 uppercase">Income Default</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Create Custom Category Modal -->
    <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div @click.outside="createModalOpen = false" class="glass-panel w-full max-w-md p-6 border shadow-2xl relative"
             :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
            <div class="flex items-center justify-between pb-3 border-b border-slate-700/50">
                <h3 class="text-base font-bold">Create Personal Category</h3>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="{{ route('user.categories.store') }}" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Category Name *</label>
                    <input type="text" name="name" placeholder="e.g. Gym Membership, Tech Gadgets" required
                           class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Type *</label>
                    <select name="type" required class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs">
                        <option value="expense">Expense</option>
                        <option value="income">Income</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Category Color Badge</label>
                    <input type="color" name="color" value="#3B82F6" class="w-16 h-8 rounded border border-slate-700 bg-transparent cursor-pointer">
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="createModalOpen = false" class="px-3 py-1.5 rounded-lg text-xs text-slate-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Custom Category Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div @click.outside="editModalOpen = false" class="glass-panel w-full max-w-md p-6 border shadow-2xl relative"
             :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
            <div class="flex items-center justify-between pb-3 border-b border-slate-700/50">
                <h3 class="text-base font-bold">Edit Personal Category</h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>

            <form :action="editFormUrl" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Category Name *</label>
                    <input type="text" name="name" x-model="editingCategory.name" required
                           class="w-full px-3 py-2 rounded-xl border bg-slate-900/60 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Badge Color</label>
                    <input type="color" name="color" x-model="editingCategory.color" class="w-16 h-8 rounded border border-slate-700 bg-transparent cursor-pointer">
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="editModalOpen = false" class="px-3 py-1.5 rounded-lg text-xs text-slate-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function categoryManager() {
        return {
            createModalOpen: false,
            editModalOpen: false,
            editingCategory: {},
            editFormUrl: '',

            openEditModal(cat) {
                this.editingCategory = { ...cat };
                this.editFormUrl = `{{ url('/categories') }}/${cat.id}`;
                this.editModalOpen = true;
            }
        };
    }
</script>
@endpush
