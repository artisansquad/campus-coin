<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Coin — Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
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
        }
    </script>

    <style>
        :root {
            --bg: #0A0F1E;
            --card: #1B2A41;
            --primary: #3B82F6;
            --muted: #94A3B8;
            --text: #E2E8F0;
            --panel: rgba(27, 42, 65, 0.82);
            --border: rgba(148,163,184,0.16);
            --soft: rgba(59, 130, 246, 0.10);
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 15% 10%, rgba(59, 130, 246, 0.12), transparent 30%),
                radial-gradient(circle at 85% 90%, rgba(59, 130, 246, 0.08), transparent 32%),
                var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        [x-cloak] { display: none !important; }

        .grid-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .16;
            background-image:
                linear-gradient(rgba(148, 163, 184, .045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, .045) 1px, transparent 1px);
            background-size: 55px 55px;
            mask-image: linear-gradient(to bottom, black, transparent 90%);
            z-index: 0;
        }

        .ambient {
            position: fixed;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(120px);
            opacity: .12;
            z-index: 0;
        }

        .ambient.one {
            top: -260px;
            left: -150px;
            background: var(--primary);
        }

        .ambient.two {
            right: -260px;
            bottom: -250px;
            background: var(--primary);
        }

        .particle {
            position: fixed;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--primary);
            box-shadow: 0 0 12px rgba(59,130,246,.55);
            opacity: .35;
            pointer-events: none;
            animation: particleFloat 9s infinite ease-in-out;
            z-index: 1;
        }

        @keyframes particleFloat {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(25px, -70px); }
        }

        .glass {
            background: rgba(27, 42, 65, 0.78);
            border: 1px solid rgba(148,163,184,.14);
            box-shadow: 0 25px 70px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.03);
            backdrop-filter: blur(16px);
        }

        .glass:hover {
            border-color: rgba(59,130,246,.28);
            box-shadow: 0 30px 80px rgba(0,0,0,.34), 0 0 30px rgba(59,130,246,.06), inset 0 1px 0 rgba(255,255,255,.035);
        }

        .sidebar {
            background: linear-gradient(180deg, rgba(27,42,65,.98), rgba(10,15,30,.98));
            border-right: 1px solid rgba(148,163,184,.12);
        }

        .sidebar-link {
            position: relative;
            transition: .25s ease;
        }

        .sidebar-link:hover {
            transform: translateX(4px);
            background: rgba(59,130,246,.08);
            color: #E2E8F0;
        }

        .sidebar-link.active {
            color: white;
            background: linear-gradient(90deg, rgba(59,130,246,.18), rgba(59,130,246,.04));
            box-shadow: inset 3px 0 0 #3B82F6;
        }

        .sidebar-link.active::after {
            content: "";
            position: absolute;
            right: 13px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #3B82F6;
            box-shadow: 0 0 12px #3B82F6;
        }

        .topbar {
            background: rgba(10,15,30,.76);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(148,163,184,.10);
        }

        .input-dark {
            background: #0A0F1E;
            border: 1px solid rgba(148,163,184,.17);
            color: #E2E8F0;
            transition: .25s;
        }

        .input-dark::placeholder { color: #64748B; }
        .input-dark:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59,130,246,.09);
        }

        .stat-card {
            transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(59,130,246,.30);
            box-shadow: 0 25px 55px rgba(0,0,0,.28), 0 0 30px rgba(59,130,246,.08);
        }

        .icon-box {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: rgba(59,130,246,.10);
            color: #60A5FA;
            border: 1px solid rgba(59,130,246,.14);
        }

        .chart-line {
            stroke-dasharray: 700;
            stroke-dashoffset: 700;
            animation: drawChart 1.8s ease forwards;
        }

        @keyframes drawChart {
            to { stroke-dashoffset: 0; }
        }

        .bar {
            transform-origin: bottom;
            animation: barGrow .9s ease both;
        }

        @keyframes barGrow {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

        .pulse-dot { animation: dotPulse 2s infinite; }

        @keyframes dotPulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 rgba(59,130,246,0); }
            50% { opacity: .55; box-shadow: 0 0 15px rgba(59,130,246,.65); }
        }

        .fade-up { animation: fadeUp .5s ease both; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .robot-wrapper {
            position: relative;
            width: 155px;
            animation: robotFloat 4s ease-in-out infinite;
        }

        @keyframes robotFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-9px); }
        }

        .robot-wrapper::after {
            content: "";
            position: absolute;
            width: 125px;
            height: 25px;
            left: 15px;
            bottom: -12px;
            border-radius: 50%;
            background: rgba(59,130,246,.18);
            filter: blur(17px);
            z-index: -1;
        }

        .robot-head {
            position: relative;
            width: 145px;
            height: 118px;
            margin: auto;
            border-radius: 38px;
            background: linear-gradient(145deg,#1B2A41,#101A2C);
            border: 1px solid rgba(148,163,184,.20);
            box-shadow: 0 18px 40px rgba(0,0,0,.35), 0 0 30px rgba(59,130,246,.12), inset 0 1px 0 rgba(255,255,255,.05);
        }

        .robot-antenna {
            position: absolute;
            width: 3px;
            height: 27px;
            left: 50%;
            top: -26px;
            transform: translateX(-50%);
            border-radius: 10px;
            background: #3B82F6;
        }

        .robot-signal {
            position: absolute;
            width: 9px;
            height: 9px;
            left: 50%;
            top: -7px;
            transform: translateX(-50%);
            border-radius: 50%;
            background: #3B82F6;
            box-shadow: 0 0 10px #3B82F6;
            animation: signalPulse 1.6s infinite;
        }

        @keyframes signalPulse {
            0%,100% { transform: translateX(-50%) scale(1); }
            50% { transform: translateX(-50%) scale(.65); opacity: .45; }
        }

        .robot-eye {
            position: absolute;
            top: 35px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #0A0F1E;
            border: 1px solid rgba(59,130,246,.8);
            box-shadow: 0 0 15px rgba(59,130,246,.16);
        }

        .robot-eye.left { left: 28px; }
        .robot-eye.right { right: 28px; }

        .eye-pupil {
            position: absolute;
            width: 11px;
            height: 11px;
            left: 8px;
            top: 8px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 30%, #E2E8F0 0 10%, #60A5FA 30%, #2563EB 75%);
            box-shadow: 0 0 10px #3B82F6;
        }

        .robot-mouth {
            position: absolute;
            width: 43px;
            height: 13px;
            left: 51px;
            bottom: 18px;
            border-bottom: 2px solid #3B82F6;
            border-radius: 50%;
        }

        .robot-body {
            position: relative;
            width: 112px;
            height: 72px;
            margin: -2px auto 0;
            border-radius: 25px;
            background: linear-gradient(145deg,#1B2A41,#101A2C);
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 18px 35px rgba(0,0,0,.30);
        }

        .robot-core {
            position: absolute;
            width: 34px;
            height: 34px;
            left: 50%;
            top: 17px;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #3B82F6;
            color: white;
            font-weight: 800;
            box-shadow: 0 0 18px rgba(59,130,246,.35);
            animation: corePulse 2s infinite;
        }

        @keyframes corePulse {
            0%,100% { transform: translateX(-50%) scale(1); }
            50% { transform: translateX(-50%) scale(1.08); }
        }

        .table-row { transition: .2s ease; }
        .table-row:hover { background: rgba(59,130,246,.055); }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-active {
            color: #60A5FA;
            background: rgba(59,130,246,.10);
            border: 1px solid rgba(59,130,246,.16);
        }

        .status-inactive {
            color: #94A3B8;
            background: rgba(148,163,184,.08);
            border: 1px solid rgba(148,163,184,.12);
        }

        .progress-track {
            height: 7px;
            border-radius: 999px;
            background: rgba(10,15,30,.85);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg,#2563EB,#60A5FA);
        }

        .mobile-overlay {
            background: rgba(0,0,0,.58);
            backdrop-filter: blur(3px);
        }

        @media(max-width: 1023px) {
            .desktop-sidebar { transform: translateX(-100%); transition: transform .3s ease; }
            .desktop-sidebar.open { transform: translateX(0); }
        }
    </style>
</head>
<body x-data="adminPanel()" x-init="startCounters()">
    <div class="grid-bg"></div>
    <div class="ambient one"></div>
    <div class="ambient two"></div>

    <div class="particle" style="left:7%;top:20%;"></div>
    <div class="particle" style="left:19%;top:73%;animation-delay:1s;"></div>
    <div class="particle" style="left:84%;top:17%;animation-delay:2s;"></div>
    <div class="particle" style="left:93%;top:68%;animation-delay:3s;"></div>
    <div class="particle" style="left:63%;top:9%;animation-delay:4s;"></div>
    <div class="particle" style="left:44%;top:88%;animation-delay:2.5s;"></div>

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 mobile-overlay lg:hidden"></div>

    <aside class="desktop-sidebar fixed left-0 top-0 bottom-0 w-[270px] z-50" :class="{ 'open': sidebarOpen }">
        <div class="sidebar h-full flex flex-col">
            <div class="h-20 px-6 flex items-center border-b border-slate-700/20">
                <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center text-white font-black shadow-lg shadow-blue-500/20">$</div>
                <div class="ml-3">
                    <div class="font-bold text-white tracking-tight">Campus Coin</div>
                    <div class="text-[10px] text-blue-400 uppercase tracking-[.2em]">Admin Console</div>
                </div>
            </div>

            <div class="px-4 pt-7">
                <p class="px-3 mb-3 text-[10px] uppercase tracking-[.22em] text-slate-500 font-semibold">Workspace</p>
                <nav class="space-y-1">
                    <button @click="setTab('dashboard')" :class="{ 'active': activeTab === 'dashboard' }" class="sidebar-link w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"/></svg>
                        Dashboard
                    </button>
                    <button @click="setTab('users')" :class="{ 'active': activeTab === 'users' }" class="sidebar-link w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                        Users
                        <span class="ml-auto text-[10px] text-slate-500">12.8K</span>
                    </button>
                    <button @click="setTab('analytics')" :class="{ 'active': activeTab === 'analytics' }" class="sidebar-link w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19V5M4 19h16M8 16v-4M12 16V8M16 16v-7"/></svg>
                        Analytics
                    </button> 
                    
                </nav>


            <div class="mt-auto px-5 pb-6">
                <div class="rounded-2xl border border-blue-400/10 bg-blue-500/[.04] p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-2 h-2 rounded-full bg-blue-500 pulse-dot"></span>
                        <span class="text-[10px] uppercase tracking-[.2em] text-blue-400 font-semibold">AI Assistant</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/10 flex items-center justify-center"><span class="text-blue-400 font-bold">$</span></div>
                        <div>
                            <p class="text-xs text-slate-300">Campus Bot</p>
                            <p class="text-[10px] text-slate-500">System online</p>
                        </div>
                    </div>
                </div>
                <p class="text-[10px] text-slate-600 text-center mt-4">Campus Coin v1.0 • Admin</p>
            </div>
        </div>
    </aside>

    <div class="lg:ml-[270px] relative z-10 min-h-screen">
        <header class="topbar sticky top-0 z-30 h-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 rounded-xl border border-slate-700/50 bg-slate-900/50 text-slate-300">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <p class="text-xs text-slate-500 hidden sm:block">Campus Coin</p>
                    <h1 class="text-lg font-bold text-white">Admin Dashboard</h1>
                </div>
            </div>

            <div class="hidden md:block relative w-[330px] lg:w-[390px]">
                

            <div class="flex items-center gap-2 sm:gap-4">
                <div x-data='{
                    open: false,
                    notifications: @json($adminNotifications ?? []),
                    unreadCount() {
                        return (this.notifications || []).filter((n) => !n.is_read).length;
                    }
                }' class="relative">
                    <button @click="open = !open" aria-label="Notifications" class="relative w-10 h-10 rounded-xl border border-slate-700/50 bg-slate-900/40 text-slate-400 hover:text-blue-400 hover:border-blue-400/20 transition">
                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.5-1.5V11a6.5 6.5 0 00-5-6.32V4a1.5 1.5 0 00-3 0v.68A6.5 6.5 0 005.5 11v4.5L4 17h5m6 0a3 3 0 01-6 0"/></svg>
                        <span x-show="unreadCount() > 0" x-cloak class="absolute -top-1 -right-1 flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-blue-500 text-[10px] text-white font-bold" x-text="unreadCount()"></span>
                    </button>

                    <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 mt-3 w-[360px] max-h-[420px] overflow-hidden rounded-2xl border border-slate-700/60 bg-slate-950/95 shadow-2xl shadow-slate-950/50">
                        <div class="flex items-center justify-between border-b border-slate-800 px-4 py-3">
                            <h3 class="text-sm font-semibold text-white">Notifications</h3>
                            <span class="text-[10px] uppercase tracking-[.2em] text-slate-400" x-text="(notifications || []).length + ' total'"></span>
                        </div>

                        <div class="max-h-[360px] overflow-y-auto">
                            <template x-if="(notifications || []).length === 0">
                                <div class="px-4 py-8 text-center text-sm text-slate-400">No notifications yet.</div>
                            </template>

                            <template x-for="notification in notifications || []" :key="notification.id">
                                <div class="border-b border-slate-800/80 px-4 py-3 hover:bg-slate-900/60">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1 h-2.5 w-2.5 rounded-full" :class="notification.is_read ? 'bg-slate-600' : 'bg-blue-500'"></div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-white" x-text="notification.title"></p>
                                            <p class="mt-1 text-[11px] text-slate-400">
                                                <span class="font-medium text-blue-300" x-text="notification.sender_name || 'Unknown sender'"></span>
                                                <span class="mx-1">•</span>
                                                <span x-text="notification.sender_email || 'No email'"></span>
                                            </p>
                                            <p class="mt-2 text-sm text-slate-300 line-clamp-3" x-text="notification.message"></p>
                                            <p class="mt-2 text-[10px] uppercase tracking-[.18em] text-slate-500" x-text="notification.created_at ? new Date(notification.created_at).toLocaleString([], { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit' }) : 'Just now'"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block h-8 w-px bg-slate-700/40"></div>
                <div x-data="{ profileOpen: false }" class="relative">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">AD</div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-semibold text-slate-200">Admin</p>
                            <p class="text-[10px] text-slate-500">Super Administrator</p>
                        </div>
                        <svg class="hidden sm:block w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/></svg>
                    </button>

                    <div x-show="profileOpen" x-cloak @click.outside="profileOpen = false" class="absolute right-0 mt-3 w-[180px] rounded-2xl border border-slate-700/60 bg-slate-950/95 shadow-2xl shadow-slate-950/50 overflow-hidden">
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:bg-slate-900/60 hover:text-red-400 transition border-b border-slate-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            <section x-show="activeTab === 'dashboard'" x-cloak x-transition.opacity class="fade-up">
                <div class="mb-7">
                    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 text-blue-400 text-xs font-semibold tracking-[.22em] uppercase">
                                <span class="w-7 h-px bg-blue-500"></span>
                                Overview
                            </div>
                            <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight mt-3">Good evening, Admin.</h2>
                            <p class="text-slate-400 mt-2">Here's what's happening across Campus Coin today.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="refreshDashboardData()" :disabled="isRefreshing" :class="isRefreshing ? 'opacity-70 cursor-not-allowed' : ''" class="px-4 py-2.5 rounded-xl bg-blue-500 text-white text-sm font-semibold hover:bg-blue-600 transition shadow-lg shadow-blue-500/10">
                                <span x-text="isRefreshing ? 'Refreshing...' : 'Refresh Data'"></span>
                            </button>
                            <button @click="exportDashboardData()" class="px-4 py-2.5 rounded-xl border border-slate-700 bg-slate-900/50 text-slate-300 text-sm hover:border-blue-400/30 transition">Export</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6 gap-4 mb-6">
                    <template x-for="stat in stats" :key="stat.label">
                        <div class="glass stat-card rounded-2xl p-5">
                            <div class="flex items-start justify-between">
                                <div class="icon-box" :class="stat.bg" x-html="stat.icon"></div>
                                <span class="text-[10px] px-2 py-1 rounded-full text-blue-400 bg-blue-500/10" x-text="stat.change"></span>
                            </div>
                            <p class="text-xs text-slate-500 mt-4" x-text="stat.label"></p>
                            <p class="text-2xl font-bold text-white mt-1">
                                <span x-text="stat.prefix || ''"></span>
                                <span x-text="animatedStats[stat.key]"></span>
                                <span x-text="stat.suffix || ''"></span>
                            </p>
                        </div>
                    </template>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-5">
                    <div class="glass rounded-2xl p-5 xl:col-span-2">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="font-semibold text-white">User Growth</h3>
                                <p class="text-xs text-slate-500 mt-1">New registered users over the last 7 months</p>
                            </div>
                            <span class="text-xs text-blue-400 bg-blue-500/10 px-3 py-1.5 rounded-lg">+18.4%</span>
                        </div>
                        <div class="h-[240px]">
                            <svg viewBox="0 0 700 240" class="w-full h-full" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="areaGradient" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#3B82F6" stop-opacity=".25"/>
                                        <stop offset="100%" stop-color="#3B82F6" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <g stroke="#94A3B8" stroke-opacity=".07">
                                    <line x1="0" y1="30" x2="700" y2="30"/>
                                    <line x1="0" y1="85" x2="700" y2="85"/>
                                    <line x1="0" y1="140" x2="700" y2="140"/>
                                    <line x1="0" y1="195" x2="700" y2="195"/>
                                </g>
                                <path d="M0,194 C60,185 80,178 120,164 S180,149 220,156 S270,133 320,119 S380,108 420,114 S470,87 520,77 S575,60 620,48 S670,36 700,27 L700,240 L0,240 Z" fill="url(#areaGradient)"/>
                                <path class="chart-line" d="M0,194 C60,185 80,178 120,164 S180,149 220,156 S270,133 320,119 S380,108 420,114 S470,87 520,77 S575,60 620,48 S670,36 700,27" fill="none" stroke="#3B82F6" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="700" cy="27" r="5" fill="#3B82F6"><animate attributeName="r" values="4;7;4" dur="2s" repeatCount="indefinite"/></circle>
                            </svg>
                        </div>
                        <div class="grid grid-cols-7 text-[10px] text-slate-600 mt-1">
                            <span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span class="text-blue-400">Sep</span>
                        </div>
                    </div>

                    <div class="glass rounded-2xl p-5">
                        <div class="mb-6">
                            <h3 class="font-semibold text-white">Goal Completion</h3>
                            <p class="text-xs text-slate-500 mt-1">Platform-wide goal progress</p>
                        </div>
                        <div class="relative w-40 h-40 mx-auto">
                            <svg class="w-full h-full -rotate-90">
                                <circle cx="80" cy="80" r="63" fill="none" stroke="#0A0F1E" stroke-width="14"/>
                                <circle cx="80" cy="80" r="63" fill="none" stroke="#3B82F6" stroke-width="14" stroke-linecap="round" stroke-dasharray="396" stroke-dashoffset="99"/>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-white">75%</span>
                                <span class="text-[10px] text-slate-500">completed</span>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3">
                            <div class="flex justify-between text-xs"><span class="text-slate-400">Completed</span><span class="text-white">8,430</span></div>
                            <div class="progress-track"><div class="progress-fill" style="width:75%"></div></div>
                            <div class="flex justify-between text-xs"><span class="text-slate-400">In progress</span><span class="text-white">2,820</span></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-5">
                    <div class="glass rounded-2xl p-5 xl:col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-semibold text-white">Transactions Overview</h3>
                                <p class="text-xs text-slate-500 mt-1">Monthly transaction volume</p>
                            </div>
                            <span class="text-xs text-slate-500">Last 6 months</span>
                        </div>
                        <div class="h-[220px] flex items-end gap-3 sm:gap-6 px-2">
                            <template x-for="(value,index) in transactionBars" :key="index">
                                <div class="flex-1 h-full flex flex-col justify-end items-center gap-2">
                                    <div class="w-full max-w-[45px] rounded-t-lg bg-gradient-to-t from-blue-600 to-blue-400 bar" :style="'height:' + value + '%; animation-delay:' + (index * .08) + 's'" ></div>
                                    <span class="text-[10px] text-slate-600" x-text="transactionMonths[index]"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="glass rounded-2xl p-5 overflow-hidden">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 pulse-dot"></span>
                                    <span class="text-[10px] uppercase tracking-[.2em] text-blue-400 font-semibold">AI Assistant</span>
                                </div>
                                <h3 class="text-lg font-bold text-white mt-2">Campus Bot</h3>
                            </div>
                            <span class="text-[10px] text-slate-500">LIVE</span>
                        </div>

                        <div class="flex justify-center py-2">
                            <div class="robot-wrapper">
                                <div class="robot-antenna"><span class="robot-signal"></span></div>
                                <div class="robot-head">
                                    <div class="robot-eye left"><div class="eye-pupil"></div></div>
                                    <div class="robot-eye right"><div class="eye-pupil"></div></div>
                                    <div class="robot-mouth"></div>
                                </div>
                                <div class="robot-body"><div class="robot-core">$</div></div>
                            </div>
                        </div>

                        <div class="rounded-xl bg-slate-950/35 border border-slate-700/30 p-4">
                            <p class="text-xs uppercase tracking-wider text-blue-400 font-semibold mb-2">Today's insight</p>
                            <p class="text-sm leading-relaxed text-slate-300">User growth is increasing steadily this month. Savings activity is also trending upward across active student accounts.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                    <div class="glass rounded-2xl p-5">
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h3 class="font-semibold text-white">Recent Activity</h3>
                                <p class="text-xs text-slate-500 mt-1">Latest platform events</p>
                            </div>
                            <button class="text-xs text-blue-400 hover:text-blue-300">View all</button>
                        </div>
                        <div class="space-y-1">
                            <template x-for="activity in activities" :key="activity.title">
                                <div class="flex gap-3 p-3 rounded-xl hover:bg-slate-900/30 transition">
                                    <div class="w-9 h-9 rounded-xl flex-shrink-0 flex items-center justify-center" :class="activity.bg" x-html="activity.icon"></div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm text-slate-300" x-text="activity.title"></p>
                                        <p class="text-xs text-slate-600 mt-1" x-text="activity.time"></p>
                                    </div>
                                    <span class="text-xs text-slate-500" x-text="activity.value"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="glass rounded-2xl p-5">
                        <div class="mb-5">
                            <h3 class="font-semibold text-white">System Status</h3>
                            <p class="text-xs text-slate-500 mt-1">Infrastructure health</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <template x-for="system in systems" :key="system.name">
                                <div class="rounded-xl bg-slate-950/35 border border-slate-700/30 p-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-slate-400" x-text="system.name"></span>
                                        <span class="w-2 h-2 rounded-full bg-blue-500 pulse-dot"></span>
                                    </div>
                                    <p class="text-lg font-bold text-white mt-4" x-text="system.status"></p>
                                    <p class="text-[10px] text-slate-600 mt-1" x-text="system.detail"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <section x-show="activeTab === 'users'" x-cloak x-transition.opacity class="fade-up">
                <div class="mb-7">
                    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 text-blue-400 text-xs font-semibold tracking-[.22em] uppercase"><span class="w-7 h-px bg-blue-500"></span>Management</div>
                            <h2 class="text-3xl font-bold text-white mt-3">Users</h2>
                            <p class="text-slate-400 mt-2">Manage student accounts and platform activity.</p>
                        </div>
                        <button @click="notify('Create user form opened')" class="px-4 py-2.5 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold transition">+ Add User</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
                    <div class="glass rounded-2xl p-5"><p class="text-xs text-slate-500">Total Users</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $totalStudents }}</p><span class="text-xs text-blue-400">+8.2% this month</span></div>
                    <div class="glass rounded-2xl p-5"><p class="text-xs text-slate-500">Active Users</p><p class="text-2xl font-bold text-white mt-2">{{ $activeStudentsCount }}</p><span class="text-xs text-blue-400">{{ $totalStudents > 0 ? round(($activeStudentsCount / $totalStudents) * 100) : 0 }}% active</span></div>
                    <div class="glass rounded-2xl p-5"><p class="text-xs text-slate-500">New This Month</p><p class="text-2xl font-bold text-white mt-2">{{ $thisMonthTransactions }}</p><span class="text-xs text-blue-400">This month</span></div>
                    <div class="glass rounded-2xl p-5"><p class="text-xs text-slate-500">Transactions</p><p class="text-2xl font-bold text-white mt-2">{{ $totalTransactionsCount }}</p><span class="text-xs text-blue-400">Total logs</span></div>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-700/30">
                        <div class="flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">
                            <div class="relative flex-1 max-w-lg">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                <input x-model="userSearch" type="text" placeholder="Search users..." class="input-dark w-full rounded-xl pl-10 pr-4 py-2.5 text-sm">
                            </div>
                            <div class="flex gap-2">
                                <select x-model="userStatus" class="input-dark rounded-xl px-3 py-2.5 text-sm">
                                    <option value="all">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[900px]">
                            <thead class="bg-slate-950/25">
                                <tr class="text-[10px] uppercase tracking-wider text-slate-500">
                                    <th class="px-5 py-4">ID</th>
                                    <th class="px-5 py-4">Name</th>
                                    <th class="px-5 py-4">Email</th>
                                    <th class="px-5 py-4">Join Date</th>
                                    <th class="px-5 py-4">Status</th>
                                    <th class="px-5 py-4">Goals</th>
                                    <th class="px-5 py-4">Transactions</th>
                                   
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/20">
                                @forelse ($students as $student)
                                    <tr class="table-row">
                                        <td class="px-5 py-4 text-xs text-slate-500">#{{ $student->id }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold text-white" style="background: {{ $student->id % 2 === 0 ? 'linear-gradient(135deg, #3B82F6, #60A5FA)' : 'linear-gradient(135deg, #8B5CF6, #A78BFA)' }};">
                                                    {{ strtoupper(substr(trim(($student->name ?? '') . ' ' . ($student->last_name ?? '')), 0, 2) ?: 'ST') }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-slate-200">{{ trim(($student->name ?? '') . ' ' . ($student->last_name ?? '')) ?: $student->name }}</p>
                                                    <p class="text-[10px] text-slate-600">Student</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-slate-400">{{ $student->email }}</td>
                                        <td class="px-5 py-4 text-xs text-slate-500">{{ $student->created_at?->format('M d, Y') ?? '—' }}</td>
                                        <td class="px-5 py-4">
                                            <span class="status {{ $student->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $student->status === 'active' ? 'bg-blue-400' : 'bg-slate-500' }}"></span>
                                                <span>{{ ucfirst($student->status ?? 'active') }}</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-slate-300">{{ $student->insights()->count() }}</td>
                                        <td class="px-5 py-4 text-sm text-slate-300">{{ $student->transactions()->count() }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex justify-end gap-1">
                                                <form action="{{ route('admin.users.toggle', $student) }}" method="POST">
                                                    @csrf
                                                   
                                                </form>
                                               
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-5 py-6 text-center text-sm text-slate-400">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-5 py-4 border-t border-slate-700/30 flex items-center justify-between">
                        <p class="text-xs text-slate-600">Showing {{ $students->count() }} students</p>
                        <div class="flex gap-1">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>

                <div x-show="showUserPreview" x-cloak @click.self="showUserPreview = false" class="fixed inset-0 z-[80] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
                    <div x-transition class="glass rounded-3xl w-full max-w-md p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] uppercase tracking-[.2em] text-blue-400">User Profile</p>
                                <h3 class="text-2xl font-bold text-white mt-2">Preview</h3>
                            </div>
                            <button @click="showUserPreview = false" class="w-9 h-9 rounded-xl bg-slate-900/50 text-slate-400 hover:text-white">×</button>
                        </div>
                        <div class="flex items-center gap-4 mt-7">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-xl font-bold text-white" :style="'background:' + (selectedUser?.color || '#3B82F6')" x-text="selectedUser?.initials || 'CC'"></div>
                            <div>
                                <h4 class="text-xl font-bold text-white" x-text="selectedUser?.name"></h4>
                                <p class="text-sm text-slate-500" x-text="selectedUser?.email"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3 mt-7">
                            <div class="rounded-xl bg-slate-950/30 p-4 text-center"><p class="text-xl font-bold text-white" x-text="selectedUser?.goals"></p><p class="text-[10px] text-slate-600 mt-1">Goals</p></div>
                            <div class="rounded-xl bg-slate-950/30 p-4 text-center"><p class="text-xl font-bold text-white" x-text="selectedUser?.transactions"></p><p class="text-[10px] text-slate-600 mt-1">Transactions</p></div>
                            <div class="rounded-xl bg-slate-950/30 p-4 text-center"><p class="text-xl font-bold text-white">92%</p><p class="text-[10px] text-slate-600 mt-1">Engagement</p></div>
                        </div>
                        <button @click="showUserPreview = false" class="w-full mt-6 py-3 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold transition">Close Preview</button>
                    </div>
                </div>
            </section>

            <section x-show="activeTab === 'analytics'" x-cloak x-transition.opacity class="fade-up">
                <div class="mb-7">
                    <div class="flex flex-col xl:flex-row xl:justify-between xl:items-end gap-4">
                        <div>
                            <div class="flex items-center gap-2 text-blue-400 text-xs font-semibold tracking-[.22em] uppercase"><span class="w-7 h-px bg-blue-500"></span>Intelligence</div>
                            <h2 class="text-3xl sm:text-4xl font-bold text-white mt-3">Platform Analytics</h2>
                            <p class="text-slate-400 mt-2">Understand user behavior, transactions and financial activity.</p>
                        </div>
                        <select class="input-dark rounded-xl px-4 py-2.5 text-sm">
                            <option>Last 12 months</option>
                            <option>Last 6 months</option>
                            <option>Last 30 days</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
                    <template x-for="(stat, index) in analyticsStats.slice(0, 4)" :key="index">
                        <div class="glass rounded-2xl p-5 stat-card">
                            <p class="text-xs text-slate-500" x-text="stat.label"></p>
                            <p class="text-3xl font-bold text-white mt-2" x-text="formatMetricValue(stat)"></p>
                            <p class="text-xs mt-2" :class="(Number(stat.change) || 0) >= 0 ? 'text-blue-400' : 'text-rose-400'" x-text="formatMetricDelta(stat)"></p>
                        </div>
                    </template>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mb-5">
                    <div class="glass rounded-2xl p-5">
                        <div class="flex justify-between items-center mb-6">
                            <div><h3 class="font-semibold text-white">Savings Trends</h3><p class="text-xs text-slate-500 mt-1">Average monthly savings</p></div>
                            <span class="text-xs text-blue-400 bg-blue-500/10 px-3 py-1.5 rounded-lg" x-text="formatMetricDelta(analyticsStats[0] || { change: 0 })"></span>
                        </div>
                        <svg viewBox="0 0 520 220" class="w-full h-[220px]">
                            <g stroke="#94A3B8" stroke-opacity=".08">
                                <line x1="30" y1="20" x2="30" y2="180"/>
                                <line x1="30" y1="180" x2="490" y2="180"/>
                            </g>
                            <path :d="buildLinePath(transactionBars)" fill="none" stroke="#3B82F6" stroke-width="3" stroke-linecap="round"/>
                            <path :d="buildLinePath(transactionBars, true)" fill="none" stroke="#60A5FA" stroke-width="2" stroke-linecap="round" stroke-dasharray="8 10"/>
                        </svg>
                    </div>

                    <div class="glass rounded-2xl p-5">
                        <div class="flex justify-between items-center mb-6">
                            <div><h3 class="font-semibold text-white">Transaction Analytics</h3><p class="text-xs text-slate-500 mt-1">Platform activity breakdown</p></div>
                            <span class="text-xs text-slate-500">Live data</span>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-xs text-slate-400 mb-2"><span>Successful payments</span><span class="text-white" x-text="formatMetricValue(analyticsStats[0] || { value: 0, suffix: '%' })"></span></div>
                                <div class="progress-track"><div class="progress-fill" :style="'width:' + Math.min(100, Number(analyticsStats[0]?.value ?? 0)) + '%'" ></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs text-slate-400 mb-2"><span>Budget adherence</span><span class="text-white" x-text="formatMetricValue(analyticsStats[2] || { value: 0, suffix: '%' })"></span></div>
                                <div class="progress-track"><div class="progress-fill" :style="'width:' + Math.min(100, Number(analyticsStats[2]?.value ?? 0)) + '%'" ></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs text-slate-400 mb-2"><span>Goal completion</span><span class="text-white" x-text="formatMetricValue(analyticsStats[3] || { value: 0, suffix: '%' })"></span></div>
                                <div class="progress-track"><div class="progress-fill" :style="'width:' + Math.min(100, Number(analyticsStats[3]?.value ?? 0)) + '%'" ></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs text-slate-400 mb-2"><span>Platform activity</span><span class="text-white" x-text="Number(analyticsStats[1]?.value ?? 0).toLocaleString()"></span></div>
                                <div class="progress-track"><div class="progress-fill" :style="'width:' + Math.min(100, Number(analyticsStats[1]?.value ?? 0) / Math.max(1, Number(analyticsStats[1]?.value ?? 0)) * 100) + '%'" ></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            

           
        </main>
    </div>

    <script>
        function adminPanel() {
            const panelData = @json($dashboardPanelData ?? []);

            return {
                activeTab: 'dashboard',
                sidebarOpen: false,
                globalSearch: '',
                userSearch: '',
                userStatus: 'all',
                showUserPreview: false,
                selectedUser: null,
                showCategoryForm: false,
                editingCategory: null,
                deletingCategory: null,
                isRefreshing: false,
                animatedStats: { users: 0, transactions: 0, goals:  0, revenue:  0, savings: 0, ratio: 0 },
                stats: panelData.stats || [],
                transactionBars: panelData.transactionBars || [44, 62, 54, 79, 90, 72],
                transactionMonths: panelData.transactionMonths || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                activities: panelData.activities || [],
                systems: panelData.systems || [],
                users: panelData.users || [],
                expenseCategories: panelData.expenseCategories || [],
                incomeCategories: panelData.incomeCategories || [],
                analyticsStats: panelData.analyticsStats || [],
                get filteredUsers() {
                    const searchTerm = (this.userSearch || '').trim().toLowerCase();
                    return this.users.filter((user) => {
                        const matchesSearch = !searchTerm || [user.name, user.email, user.role].join(' ').toLowerCase().includes(searchTerm);
                        const matchesStatus = this.userStatus === 'all' || (user.status || '').toLowerCase() === this.userStatus;
                        return matchesSearch && matchesStatus;
                    });
                },
                setTab(tab) { this.activeTab = tab; this.sidebarOpen = false; },
                notify(message) { console.log(message); },
                editCategory(category) {
                    this.editingCategory = { ...category };
                    this.showCategoryForm = true;
                },
                deleteCategory(category) {
                    this.deletingCategory = { ...category };
                },
                submitDeleteForm() {
                    if (!this.deletingCategory?.id) {
                        console.error('No category ID to delete');
                        return;
                    }
                    const form = document.getElementById('deleteCategoryForm');
                    form.action = '/admin/categories/' + this.deletingCategory.id;
                    form.submit();
                },
                refreshDashboardData() {
                    this.isRefreshing = true;
                    window.location.reload();
                },
                exportDashboardData() {
                    const rows = [
                        ['Section', 'Label', 'Value'],
                        ...this.stats.map((stat) => [
                            'Dashboard Stat',
                            stat.label,
                            String(stat.value ?? this.animatedStats[stat.key] ?? 0),
                        ]),
                        ...this.users.slice(0, 10).map((user) => [
                            'User',
                            user.name,
                            user.email,
                        ]),
                        ...this.activities.map((activity) => [
                            'Activity',
                            activity.title,
                            activity.value,
                        ]),
                    ];

                    const csv = rows.map((row) => row.map((cell) => `"${String(cell).replaceAll('"', '""')}"`).join(',')).join('\n');
                    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'campuscoin-admin-dashboard.csv';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                    this.notify('Dashboard export started');
                },
                startCounters() {
                    const targets = {
                        users: Number(panelData.stats?.find((item) => item.key === 'users')?.value ?? 0),
                        transactions: Number(panelData.stats?.find((item) => item.key === 'transactions')?.value ?? 0),
                        goals: Number(panelData.stats?.find((item) => item.key === 'goals')?.value ?? 0),
                        revenue: Number(panelData.stats?.find((item) => item.key === 'revenue')?.value ?? 0),
                        savings: Number(panelData.stats?.find((item) => item.key === 'savings')?.value ?? 0),
                        ratio: Number(panelData.stats?.find((item) => item.key === 'ratio')?.value ?? 0),
                    };

                    Object.keys(targets).forEach((key) => {
                        const target = Math.max(0, Number(targets[key] || 0));
                        let current = 0;

                        const step = () => {
                            current += Math.max(1, Math.round(target / 30));
                            if (current >= target) current = target;
                            this.animatedStats[key] = current;
                            if (current < target) requestAnimationFrame(step);
                        };

                        requestAnimationFrame(step);
                    });
                },
                formatMetricValue(stat) {
                    if (!stat) return '0';
                    const value = Number(stat.value ?? 0);
                    const prefix = stat.prefix ?? '';
                    const suffix = stat.suffix ?? '';
                    const formatted = value >= 1000 ? (value / 1000).toFixed(1) + 'K' : value.toLocaleString('en-US', { maximumFractionDigits: 1 });
                    return prefix + formatted + suffix;
                },
                formatMetricDelta(stat) {
                    if (!stat) return '↑ 0%';
                    const change = Number(stat.change ?? 0);
                    const arrow = change >= 0 ? '↑' : '↓';
                    return arrow + ' ' + Math.abs(change).toFixed(1) + '% ' + (stat.description || 'change');
                },
                buildLinePath(values, offset = false) {
                    if (!values || values.length === 0) return '';
                    const maxValue = Math.max(...values, 1);
                    const padding = 30;
                    const graphWidth = 520 - 2 * padding;
                    const graphHeight = 160;
                    const pointSpacing = graphWidth / (values.length - 1 || 1);
                    
                    const offsetAmount = offset ? 10 : 0;
                    const points = values.map((val, i) => {
                        const x = padding + i * pointSpacing;
                        const y = 180 - (val / maxValue) * graphHeight - offsetAmount;
                        return `${x},${y}`;
                    });
                    
                    return `M${points.join(' L')}`;
                },
                editCategory(category) {
                    this.editingCategory = { ...category };
                    this.showCategoryForm = true;
                },
                deleteCategory(category) {
                    this.deletingCategory = { ...category };
                },
                formatMetricValue(stat) {
                    if (!stat) return '';
                    const value = Number(stat.value);
                    const suffix = stat.suffix || '';
                    return `${value.toLocaleString()}${suffix}`;
                },
                formatMetricDelta(stat) {
                    if (!stat) return '';
                    const change = Number(stat.change);
                    const prefix = change >= 0 ? '+' : '';
                    return `${prefix}${change.toFixed(1)}%`;
                },
                buildLinePath(data, isDashed) {
                    if (!data || data.length === 0) return '';
                    const points = data.map((value, index) => {
                        const x = index * (520 / (data.length - 1));
                        const y = 180 - value * 1.5;
                        return `${x},${y}`;
                    });
                    return `M${points.join(' L')} L520,180`;
                }
            };
        }
    </script>
</body>
</html>
