<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Campus Coin — Student Finance Dashboard')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        navy: '#0A0F1E',
                        card: '#1B2A41',
                        muted: '#94A3B8',
                        light: '#E2E8F0'
                    }
                }
            }
        };
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        /* Font sizing variations for accessibility */
        html.font-sm { font-size: 14px; }
        html.font-md { font-size: 16px; }
        html.font-lg { font-size: 18px; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Theme (Default) */
        html.dark body {
            background-color: #0A0F1E;
            color: #E2E8F0;
            background-image: 
                radial-gradient(circle at 12% 15%, rgba(59, 130, 246, 0.12), transparent 35%),
                radial-gradient(circle at 88% 85%, rgba(59, 130, 246, 0.08), transparent 30%);
        }

        /* Light Theme (Requirement 2) */
        html:not(.dark) body {
            background-color: #F8FAFC;
            color: #0F172A;
            background-image: 
                radial-gradient(circle at 12% 15%, rgba(59, 130, 246, 0.08), transparent 35%),
                radial-gradient(circle at 88% 85%, rgba(99, 102, 241, 0.05), transparent 30%);
        }

        .glass-panel {
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 1rem;
            transition: all 0.2s ease-in-out;
        }

        html.dark .glass-panel {
            background: rgba(27, 42, 65, 0.85);
            border: 1px solid rgba(148, 163, 184, 0.15);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        html:not(.dark) .glass-panel {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.04) !important;
            color: #0F172A;
        }

        html.dark .sidebar-nav {
            background: rgba(27, 42, 65, 0.6);
            border-right: 1px solid rgba(148, 163, 184, 0.12);
        }

        html:not(.dark) .sidebar-nav {
            background: #FFFFFF;
            border-right: 1px solid #E2E8F0;
        }

        /* Light Mode High-Contrast Typography & Colors */
        html:not(.dark) h1.text-white,
        html:not(.dark) h2.text-white,
        html:not(.dark) h3.text-white,
        html:not(.dark) h4.text-white,
        html:not(.dark) p.text-white,
        html:not(.dark) .glass-panel > h1,
        html:not(.dark) .glass-panel > h2,
        html:not(.dark) .glass-panel > h3 {
            color: #0F172A !important;
        }

        html:not(.dark) .text-white:not(button):not(a):not(.keep-white) {
            color: #0F172A;
        }

        html:not(.dark) button[class*="bg-blue"],
        html:not(.dark) button[class*="bg-emerald"],
        html:not(.dark) button[class*="bg-red"],
        html:not(.dark) button[class*="bg-purple"],
        html:not(.dark) a[class*="bg-blue"],
        html:not(.dark) a[class*="bg-emerald"],
        html:not(.dark) a[class*="bg-purple"] {
            color: #FFFFFF !important;
        }

        html:not(.dark) .text-slate-100 { color: #0F172A !important; }
        html:not(.dark) .text-slate-200 { color: #1E293B !important; }
        html:not(.dark) .text-slate-300 { color: #334155 !important; }
        html:not(.dark) .text-slate-400 { color: #475569 !important; }
        html:not(.dark) .text-slate-500 { color: #64748B !important; }

        /* Light Mode Container & Inner Box Backgrounds */
        html:not(.dark) .bg-slate-900,
        html:not(.dark) .bg-slate-900\/60,
        html:not(.dark) .bg-slate-900\/50,
        html:not(.dark) .bg-slate-900\/40,
        html:not(.dark) .bg-slate-900\/30,
        html:not(.dark) .bg-slate-800,
        html:not(.dark) .bg-slate-800\/60,
        html:not(.dark) .bg-slate-800\/50,
        html:not(.dark) .bg-slate-800\/40 {
            background-color: #F8FAFC !important;
        }

        /* Light Mode Clean Borders */
        html:not(.dark) .border-slate-800,
        html:not(.dark) .border-slate-800\/80,
        html:not(.dark) .border-slate-800\/60,
        html:not(.dark) .border-slate-800\/40,
        html:not(.dark) .border-slate-700,
        html:not(.dark) .border-slate-700\/50,
        html:not(.dark) .border-slate-700\/40,
        html:not(.dark) .border-slate-700\/30,
        html:not(.dark) .divide-slate-800,
        html:not(.dark) .divide-slate-700\/20 {
            border-color: #E2E8F0 !important;
        }

        /* Light Mode Form Controls */
        html:not(.dark) input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
        html:not(.dark) select,
        html:not(.dark) textarea {
            background-color: #FFFFFF !important;
            border: 1px solid #CBD5E1 !important;
            color: #0F172A !important;
        }
        html:not(.dark) input::placeholder,
        html:not(.dark) textarea::placeholder {
            color: #94A3B8 !important;
        }
        html:not(.dark) input:focus,
        html:not(.dark) select:focus,
        html:not(.dark) textarea:focus {
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            background-color: #FFFFFF !important;
        }

        /* Light Mode Progress Bar Tracks */
        html:not(.dark) .w-full.bg-slate-900.rounded-full,
        html:not(.dark) .bg-slate-900.rounded-full {
            background-color: #E2E8F0 !important;
            border-color: #CBD5E1 !important;
        }

        /* Light Mode Sidebar Link Hover */
        html:not(.dark) aside a:not([class*="bg-blue-600"]):hover {
            background-color: #F1F5F9 !important;
            color: #2563EB !important;
        }

        /* Light Mode Tables */
        html:not(.dark) thead,
        html:not(.dark) thead tr {
            background-color: #F1F5F9 !important;
            color: #475569 !important;
        }
        html:not(.dark) thead th {
            color: #475569 !important;
            border-bottom: 1px solid #E2E8F0 !important;
        }
        html:not(.dark) tbody tr:hover {
            background-color: #F8FAFC !important;
        }

        /* Light Mode Modals */
        html:not(.dark) .fixed .glass-panel {
            background-color: #FFFFFF !important;
            border: 1px solid #CBD5E1 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(59, 130, 246, 0.5); }

        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body x-data="themeManager()" x-init="initTheme()" class="antialiased flex flex-col min-h-screen">

    <!-- Top Accessibility & Navigation Bar -->
    <header class="sticky top-0 z-40 border-b transition-colors duration-200" 
            :class="darkMode ? 'bg-[#0A0F1E]/90 border-slate-800 backdrop-blur-md' : 'bg-white/95 border-slate-200 backdrop-blur-md'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            
            <!-- Left: Brand & Mobile Sidebar Toggle -->
            <div class="flex items-center gap-3">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-blue-500 hover:bg-slate-800/40">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight" :class="darkMode ? 'text-white' : 'text-slate-900'">Campus<span class="text-blue-500">Coin</span></span>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Student</span>
                </a>
            </div>

            <!-- Center: Breadcrumbs (Requirement 42) -->
            <div class="hidden lg:flex items-center gap-2 text-xs text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
                @yield('breadcrumbs')
            </div>

            <!-- Right Controls: Quick Add, Accessibility Toggles, Notification, User -->
            <div class="flex items-center gap-3">
                <!-- Quick Add Transaction Button (Requirement 8 & 11) -->
                <button @click="$dispatch('open-quick-add')" 
                        class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-md shadow-blue-600/30 transition-all hover:scale-102">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Quick Log</span>
                </button>

                <!-- Accessibility Controls (Requirement 41) -->
                <div class="flex items-center rounded-lg border p-0.5" 
                     :class="darkMode ? 'border-slate-800 bg-slate-900/60' : 'border-slate-200 bg-slate-100'">
                    <!-- Font-size down -->
                    <button @click="changeFontSize('sm')" title="Decrease Font Size" class="px-2 py-1 text-xs font-semibold rounded hover:text-blue-400" :class="fontSize === 'sm' ? 'text-blue-500' : 'text-slate-400'">A-</button>
                    <!-- Font-size normal -->
                    <button @click="changeFontSize('md')" title="Default Font Size" class="px-2 py-1 text-xs font-semibold rounded hover:text-blue-400" :class="fontSize === 'md' ? 'text-blue-500' : 'text-slate-400'">A</button>
                    <!-- Font-size up -->
                    <button @click="changeFontSize('lg')" title="Increase Font Size" class="px-2 py-1 text-xs font-semibold rounded hover:text-blue-400" :class="fontSize === 'lg' ? 'text-blue-500' : 'text-slate-400'">A+</button>
                    <!-- Dark / Light mode toggle -->
                    <button @click="toggleDarkMode()" title="Toggle Dark/Light Mode" class="p-1 rounded text-slate-400 hover:text-amber-400 transition-colors">
                        <template x-if="darkMode">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </template>
                        <template x-if="!darkMode">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </template>
                    </button>
                </div>

                <!-- Notifications Dropdown (Requirement 31) -->
                @php
                    $unreadNotifs = Auth::user() ? Auth::user()->notifications()->where('is_read', false)->latest()->take(5)->get() : collect();
                @endphp
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-slate-800/40 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadNotifs->count() > 0)
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-red-500 text-[9px] text-white flex items-center justify-center font-bold">{{ $unreadNotifs->count() }}</span>
                        @endif
                    </button>

                    <div x-show="open" @click.outside="open = false" x-cloak
                         class="absolute right-0 mt-2 w-80 rounded-xl shadow-2xl p-3 z-50 glass-panel border"
                         :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-700/50">
                            <span class="text-xs font-semibold">Notifications</span>
                            @if($unreadNotifs->count() > 0)
                                <form method="POST" action="{{ route('notifications.readAll') }}">
                                    @csrf
                                    <button class="text-[11px] text-blue-400 hover:underline">Mark all read</button>
                                </form>
                            @endif
                        </div>
                        <div class="mt-2 space-y-2 max-h-60 overflow-y-auto">
                            @forelse($unreadNotifs as $notif)
                                <div class="p-2 rounded-lg text-xs {{ $notif->type === 'budget_alert' ? 'bg-red-500/10 border border-red-500/20' : 'bg-slate-800/40' }}">
                                    <p class="font-medium text-blue-300">{{ $notif->title }}</p>
                                    <p class="text-slate-400 mt-0.5 text-[11px]">{{ $notif->message }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 py-4 text-center">No unread notifications.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ userMenu: false }">
                    <button @click="userMenu = !userMenu" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-800/40 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-xs font-bold text-white shadow">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="hidden md:block text-left text-xs">
                            <div class="font-medium truncate max-w-[120px]" :class="darkMode ? 'text-white' : 'text-slate-900'">{{ Auth::user()->name }}</div>
                            <div class="text-slate-400 text-[10px]">{{ Auth::user()->preferred_currency ?? 'PKR' }}</div>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="userMenu" @click.outside="userMenu = false" x-cloak
                         class="absolute right-0 mt-2 w-56 rounded-xl shadow-2xl p-2 z-50 glass-panel border"
                         :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
                        <div class="px-3 py-2 border-b border-slate-700/50">
                            <p class="text-xs font-semibold text-white">{{ Auth::user()->getFullNameAttribute() }}</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="py-1 space-y-0.5 text-xs">
                            <a href="{{ route('profile.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-600/10 hover:text-blue-400 text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Profile & Settings</span>
                            </a>
                            <a href="{{ route('goals.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-400 text-slate-300">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Savings Goals</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-600/10 hover:text-blue-400 text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                <span>Manage Categories</span>
                            </a>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <span class="font-semibold">Admin Panel</span>
                                </a>
                            @endif
                        </div>
                        <div class="pt-1 border-t border-slate-700/50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-red-400 hover:bg-red-500/10 text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Workspace Container -->
    <div class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row gap-6">

        <!-- Left Navigation Sidebar -->
        <aside class="w-full md:w-64 shrink-0" :class="mobileMenuOpen ? 'block' : 'hidden md:block'">
            <div class="glass-panel p-4 sticky top-24 space-y-1">
                <div class="px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Main Menu</div>
                
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('transactions.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('transactions.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <span>Transactions</span>
                </a>

                <a href="{{ route('budgets.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('budgets.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    <span>Budgets & Limits</span>
                </a>

                <a href="{{ route('reports.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Monthly Reports</span>
                </a>

                <div class="pt-3 px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Intelligence & AI</div>

                <a href="{{ route('insights.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('insights.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>AI Insights & Tips</span>
                </a>

                <a href="{{ route('ai.coach') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('ai.coach*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>AI Financial Coach</span>
                </a>

                <div class="pt-3 px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Management</div>

                <a href="{{ route('categories.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span>Own Categories</span>
                </a>

                <a href="{{ route('goals.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('goals.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Savings Goals</span>
                </a>

                <a href="{{ route('profile.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-blue-500/10 hover:text-blue-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profile & Account</span>
                </a>

                @if(Auth::user()->isAdmin())
                    <div class="pt-3">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 border border-amber-500/20 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Admin Portal</span>
                        </a>
                    </div>
                @endif
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0">
            <!-- Flash Message Banner -->
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">&times;</button>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm shadow-lg">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Attention:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @if(session('error')) <li>{{ session('error') }}</li> @endif
                        @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <!-- AI Advisory Disclaimer Banner (Requirement 47) -->
            <div class="mt-12 py-3 px-4 rounded-xl border border-slate-800 bg-slate-900/30 text-center text-xs text-slate-500">
                <span class="font-medium text-slate-400">Notice:</span> AI-generated categorization and insights are provided strictly as smart financial suggestions and advisories. They do not constitute formal certified financial or legal counsel.
            </div>
        </main>
    </div>

    <!-- Global Quick Add Transaction Modal (Requirement 8, 11, 12, 14, 15) -->
    <div x-data="quickAddModal()" 
         @open-quick-add.window="isOpen = true"
         x-show="isOpen" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div @click.outside="isOpen = false" 
             class="glass-panel w-full max-w-lg p-6 border shadow-2xl relative"
             :class="darkMode ? 'bg-[#1B2A41] border-slate-700' : 'bg-white border-slate-200'">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-700/50">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs">+</div>
                    <span>Log New Transaction</span>
                </h3>
                <button @click="isOpen = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="{{ route('transactions.store') }}" class="mt-4 space-y-4">
                @csrf

                <!-- Type Selector: Expense vs Income -->
                <div class="grid grid-cols-2 gap-2 p-1 rounded-xl bg-slate-900/50 border border-slate-800">
                    <label class="flex items-center justify-center gap-2 py-2 rounded-lg cursor-pointer text-xs font-semibold transition-all"
                           :class="txType === 'expense' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'text-slate-400'">
                        <input type="radio" name="type" value="expense" x-model="txType" class="hidden">
                        <span>Expense Outflow</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 py-2 rounded-lg cursor-pointer text-xs font-semibold transition-all"
                           :class="txType === 'income' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'text-slate-400'">
                        <input type="radio" name="type" value="income" x-model="txType" class="hidden">
                        <span>Income Inflow</span>
                    </label>
                </div>

                <!-- Description with Live AI Category Suggestion (Requirement 14) -->
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Description / Title *</label>
                    <input type="text" name="description" x-model="description" @input.debounce.300ms="fetchAiSuggestion()" 
                           placeholder="e.g. Canteen lunch, Metro ride, Monthly allowance" required
                           class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900/70 border-slate-700 text-sm focus:border-blue-500 focus:outline-none">
                    <div x-show="aiSuggestion" x-cloak class="mt-1.5 flex items-center gap-2 text-xs text-blue-400 bg-blue-500/10 px-2.5 py-1 rounded-lg border border-blue-500/20">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>AI Suggestion: <strong x-text="aiSuggestion"></strong></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Amount -->
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Amount ({{ Auth::user()->currencySymbol() }}) *</label>
                        <input type="number" step="0.01" min="0.01" name="amount" placeholder="0.00" required
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900/70 border-slate-700 text-sm focus:border-blue-500 focus:outline-none">
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">Transaction Date *</label>
                        <input type="date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900/70 border-slate-700 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Category *</label>
                    <select name="category_id" x-model="selectedCategory" required
                            class="w-full px-3.5 py-2.5 rounded-xl border bg-slate-900/70 border-slate-700 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">-- Select Category --</option>
                        @php
                            $allCats = Auth::user()->accessibleCategories()->orderBy('name')->get();
                        @endphp
                        @foreach($allCats as $c)
                            <option value="{{ $c->id }}" data-type="{{ $c->type }}" data-name="{{ $c->name }}">{{ $c->name }} ({{ ucfirst($c->type) }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Recurring Entry (Requirement 12) -->
                <div class="p-3 rounded-xl bg-slate-900/40 border border-slate-800 space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-300">
                        <input type="checkbox" name="is_recurring" value="1" x-model="isRecurring" class="rounded border-slate-700 text-blue-600 focus:ring-0">
                        <span class="font-medium">Recurring entry (Monthly allowance, subscription, tuition)</span>
                    </label>

                    <div x-show="isRecurring" x-cloak class="mt-2 pl-5">
                        <label class="block text-[11px] text-slate-400 mb-1">Repeat Frequency</label>
                        <select name="recurring_frequency" class="w-full px-3 py-1.5 rounded-lg border bg-slate-900 border-slate-700 text-xs">
                            <option value="weekly">Weekly</option>
                            <option value="monthly" selected>Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex items-center justify-end gap-3">
                    <button type="button" @click="isOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30">Save Transaction</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function themeManager() {
            return {
                darkMode: localStorage.getItem('cc_dark_mode') !== 'false',
                fontSize: localStorage.getItem('cc_font_size') || 'md',
                mobileMenuOpen: false,

                initTheme() {
                    this.applyTheme();
                    this.applyFontSize();
                },

                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('cc_dark_mode', this.darkMode);
                    this.applyTheme();
                },

                applyTheme() {
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                },

                changeFontSize(size) {
                    this.fontSize = size;
                    localStorage.setItem('cc_font_size', size);
                    this.applyFontSize();
                },

                applyFontSize() {
                    document.documentElement.classList.remove('font-sm', 'font-md', 'font-lg');
                    document.documentElement.classList.add('font-' + this.fontSize);
                }
            };
        }

        function quickAddModal() {
            return {
                isOpen: false,
                txType: 'expense',
                description: '',
                selectedCategory: '',
                isRecurring: false,
                aiSuggestion: '',

                async fetchAiSuggestion() {
                    if (!this.description || this.description.length < 3) {
                        this.aiSuggestion = '';
                        return;
                    }
                    try {
                        const res = await fetch(`{{ route('api.ai.suggest') }}?description=${encodeURIComponent(this.description)}`);
                        const data = await res.json();
                        if (data.success && data.category_id) {
                            this.aiSuggestion = data.category_name;
                            this.selectedCategory = data.category_id;
                            if (data.category_type) {
                                this.txType = data.category_type;
                            }
                        }
                    } catch (e) {
                        // ignore network failure
                    }
                }
            };
        }
    </script>
    @stack('scripts')
</body>
</html>
