<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Coin — Features</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#3B82F6",
                        navy: "#0A0F1E",
                        card: "#1B2A41",
                        muted: "#94A3B8",
                        light: "#E2E8F0"
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: #E2E8F0;
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at 15% 10%,
                    rgba(59, 130, 246, .14),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 85% 75%,
                    rgba(59, 130, 246, .10),
                    transparent 30%
                ),
                #0A0F1E;

            overflow-x: hidden;
        }

        .grid-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .16;
            z-index: -5;

            background-image:
                linear-gradient(
                    rgba(148, 163, 184, .05) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(148, 163, 184, .05) 1px,
                    transparent 1px
                );

            background-size: 55px 55px;

            mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent 90%
                );
        }

        .ambient {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(120px);
            opacity: .12;
            z-index: -4;
        }

        .ambient.one {
            top: -280px;
            left: -180px;
            background: #3B82F6;
        }

        .ambient.two {
            right: -250px;
            bottom: -280px;
            background: #3B82F6;
        }

        .particle {
            position: fixed;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #3B82F6;

            box-shadow:
                0 0 12px
                rgba(59, 130, 246, .7);

            opacity: .35;
            pointer-events: none;
            z-index: -1;

            animation:
                particleFloat 9s infinite ease-in-out;
        }

        @keyframes particleFloat {
            0%, 100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(25px, -70px);
            }
        }

        /* NAVBAR */

        .navbar {
            background: rgba(27, 42, 65, .72);
            border-bottom: 1px solid rgba(148, 163, 184, .12);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .nav-link {
            position: relative;
            color: #94A3B8;
            transition: .25s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #E2E8F0;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            left: 50%;
            bottom: -8px;
            transform: translateX(-50%);
            background: #3B82F6;
            box-shadow: 0 0 10px rgba(59,130,246,.7);
            transition: .25s;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* GLASS */

        .glass-card {
            background: rgba(27, 42, 65, .78);
            border: 1px solid rgba(148, 163, 184, .15);

            box-shadow:
                0 25px 70px rgba(0, 0, 0, .28),
                inset 0 1px 0 rgba(255, 255, 255, .025);

            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);

            transition:
                transform .3s ease,
                border-color .3s ease,
                box-shadow .3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);

            border-color:
                rgba(59, 130, 246, .45);

            box-shadow:
                0 30px 80px rgba(0, 0, 0, .38),
                0 0 35px rgba(59, 130, 246, .10),
                inset 0 1px 0 rgba(255,255,255,.04);
        }

        .icon-box {
            background: rgba(59, 130, 246, .10);
            border: 1px solid rgba(59, 130, 246, .22);

            box-shadow:
                0 0 25px rgba(59, 130, 246, .08);

            transition: .3s;
        }

        .feature-card:hover .icon-box {
            background: rgba(59, 130, 246, .17);
            border-color: rgba(59, 130, 246, .45);

            box-shadow:
                0 0 25px rgba(59, 130, 246, .18);

            transform: scale(1.06);
        }

        /* BUTTON */

        .main-button {
            position: relative;
            overflow: hidden;
            background: #3B82F6;

            box-shadow:
                0 10px 30px
                rgba(59, 130, 246, .18);

            transition: .25s;
        }

        .main-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.14),
                    transparent
                );

            transform: skewX(-20deg);
            transition: .6s;
        }

        .main-button:hover::before {
            left: 140%;
        }

        .main-button:hover {
            transform: translateY(-2px);
            background: #2563EB;

            box-shadow:
                0 15px 35px
                rgba(59, 130, 246, .28);
        }

        /* ROBOT */

        .robot-wrapper {
            position: relative;
            width: 250px;

            animation:
                robotFloat 4s ease-in-out infinite;
        }

        @keyframes robotFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-11px);
            }
        }

        .robot-wrapper::after {
            content: "";

            position: absolute;
            width: 190px;
            height: 35px;
            left: 30px;
            bottom: -15px;
            border-radius: 50%;

            background:
                rgba(59, 130, 246, .18);

            filter: blur(20px);
            z-index: -1;
        }

        .robot-head {
            position: relative;
            width: 220px;
            height: 180px;
            margin: auto;

            border-radius: 55px;

            background:
                linear-gradient(
                    145deg,
                    #1B2A41 0%,
                    #142238 50%,
                    #101A2C 100%
                );

            border:
                1px solid
                rgba(148, 163, 184, .20);

            box-shadow:
                0 25px 60px rgba(0, 0, 0, .35),
                0 0 45px rgba(59, 130, 246, .12),
                inset 0 1px 0 rgba(255, 255, 255, .05);

            transition: .3s;
        }

        .robot-wrapper:hover .robot-head {
            transform:
                rotate(-1deg)
                scale(1.025);
        }

        .robot-antenna {
            position: absolute;
            width: 4px;
            height: 42px;
            left: 50%;
            top: -40px;

            transform: translateX(-50%);

            border-radius: 10px;
            background: #3B82F6;

            box-shadow:
                0 0 15px
                rgba(59, 130, 246, .45);
        }

        .robot-signal {
            position: absolute;
            width: 13px;
            height: 13px;
            left: 50%;
            top: -10px;

            transform: translateX(-50%);

            border-radius: 50%;
            background: #3B82F6;

            box-shadow:
                0 0 10px #3B82F6,
                0 0 25px rgba(59, 130, 246, .35);

            animation: signalPulse 1.6s infinite;
        }

        @keyframes signalPulse {
            0%, 100% {
                transform: translateX(-50%) scale(1);
                opacity: 1;
            }

            50% {
                transform: translateX(-50%) scale(.65);
                opacity: .45;
            }
        }

        .robot-ear {
            position: absolute;
            top: 65px;
            width: 20px;
            height: 52px;
            border-radius: 12px;

            background: #142238;
            border: 1px solid rgba(59, 130, 246, .45);
        }

        .robot-ear.left {
            left: -18px;
        }

        .robot-ear.right {
            right: -18px;
        }

        .robot-ear span {
            position: absolute;
            width: 6px;
            height: 6px;
            left: 5px;
            top: 20px;

            border-radius: 50%;
            background: #3B82F6;

            box-shadow:
                0 0 10px #3B82F6;
        }

        .robot-eye {
            position: absolute;
            top: 52px;
            width: 45px;
            height: 45px;
            border-radius: 50%;

            background: #0A0F1E;
            border: 1px solid rgba(59, 130, 246, .8);

            overflow: hidden;

            box-shadow:
                0 0 20px rgba(59, 130, 246, .16);

            animation: blink 5s infinite;
        }

        @keyframes blink {
            0%, 94%, 100% {
                transform: scaleY(1);
            }

            96% {
                transform: scaleY(.08);
            }
        }

        .robot-eye.left {
            left: 43px;
        }

        .robot-eye.right {
            right: 43px;
        }

        .eye-pupil {
            position: absolute;
            width: 17px;
            height: 17px;
            left: 12px;
            top: 12px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle at 35% 30%,
                    #E2E8F0 0 10%,
                    #60A5FA 30%,
                    #2563EB 75%
                );

            box-shadow:
                0 0 12px #3B82F6;
        }

        .robot-mouth {
            position: absolute;
            width: 65px;
            height: 20px;
            left: 77px;
            bottom: 29px;

            border-bottom:
                3px solid
                #3B82F6;

            border-radius: 50%;
        }

        .robot-body {
            position: relative;
            width: 175px;
            height: 115px;

            margin: -4px auto 0;

            border-radius: 38px;

            background:
                linear-gradient(
                    145deg,
                    #1B2A41,
                    #101A2C
                );

            border:
                1px solid
                rgba(148, 163, 184, .16);

            box-shadow:
                0 25px 50px rgba(0, 0, 0, .30);
        }

        .robot-chest {
            position: absolute;
            width: 72px;
            height: 72px;
            left: 50%;
            top: 21px;

            transform: translateX(-50%);

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .core {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            color: #E2E8F0;
            font-weight: 800;

            background: #3B82F6;

            border:
                2px solid
                rgba(226, 232, 240, .15);

            box-shadow:
                0 0 18px rgba(59, 130, 246, .35),
                0 8px 25px rgba(59, 130, 246, .20);

            animation: corePulse 2s infinite;
        }

        @keyframes corePulse {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        /* FLOATING ROBOT CARDS */

        .robot-card {
            position: absolute;

            background:
                rgba(27, 42, 65, .88);

            border:
                1px solid
                rgba(59, 130, 246, .25);

            box-shadow:
                0 15px 40px rgba(0,0,0,.28),
                0 0 25px rgba(59,130,246,.08);

            backdrop-filter: blur(12px);

            animation:
                miniFloat 4s ease-in-out infinite;
        }

        .robot-card.one {
            left: -85px;
            top: 35px;
        }

        .robot-card.two {
            right: -95px;
            top: 90px;
            animation-delay: -1s;
        }

        .robot-card.three {
            left: -60px;
            bottom: 20px;
            animation-delay: -2s;
        }

        .robot-card.four {
            right: -65px;
            bottom: 0;
            animation-delay: -3s;
        }

        @keyframes miniFloat {
            0%,100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-7px);
            }
        }

        /* PREVIEWS */

        .preview {
            background: #0A0F1E;
            border: 1px solid rgba(148,163,184,.10);
        }

        .mini-bar {
            height: 7px;
            border-radius: 20px;
            background: #3B82F6;
            box-shadow: 0 0 10px rgba(59,130,246,.18);
        }

        .mini-line {
            height: 5px;
            border-radius: 10px;
            background: rgba(148,163,184,.16);
        }

        .score-ring {
            width: 80px;
            height: 80px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                conic-gradient(
                    #3B82F6 0deg 313deg,
                    rgba(148,163,184,.12) 313deg 360deg
                );

            position: relative;
        }

        .score-ring::after {
            content: "";
            position: absolute;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: #0A0F1E;
        }

        .score-text {
            position: relative;
            z-index: 1;
        }

        /* SCROLL REVEAL */

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition:
                opacity .7s ease,
                transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media(max-width: 900px) {
            .robot-card {
                display: none;
            }

            .robot-wrapper {
                transform: scale(.9);
            }
        }

        @media(max-width: 640px) {
            .robot-wrapper {
                transform: scale(.78);
                margin-top: -20px;
                margin-bottom: -20px;
            }
        }
    </style>
</head>

<body>

    <!-- Background -->
    <div class="grid-bg"></div>

    <div class="ambient one"></div>
    <div class="ambient two"></div>

    <div class="particle" style="left:8%;top:22%;animation-delay:-1s;"></div>
    <div class="particle" style="left:20%;top:75%;animation-delay:-4s;"></div>
    <div class="particle" style="left:82%;top:18%;animation-delay:-2s;"></div>
    <div class="particle" style="left:92%;top:70%;animation-delay:-6s;"></div>
    <div class="particle" style="left:65%;top:8%;animation-delay:-3s;"></div>
    <div class="particle" style="left:48%;top:50%;animation-delay:-5s;"></div>

    <!-- Navbar -->
    <nav class="navbar sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between">

                <a href="index.html" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/25 flex items-center justify-center shadow-[0_0_25px_rgba(59,130,246,.1)]">
                        <span class="text-blue-400 font-bold text-lg">$</span>
                    </div>

                    <span class="text-xl font-bold tracking-tight text-white">
                        Campus <span class="text-blue-400">Coin</span>
                    </span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="nav-link text-sm">Home</a>
                    <a href="features.html" class="nav-link active text-sm">Features</a>
                    <a href="about.html" class="nav-link text-sm">
                        About
                    </a>

                    <a href="faq.html" class="nav-link text-sm">
                        Privacy & Policy
                    </a>
                    <a href="contact.html" class="nav-link text-sm">Contact</a>
                </div>

                <div class="hidden sm:flex items-center gap-3">
                    <a
                        href="login.html"
                        class="px-4 py-2.5 rounded-xl text-sm text-slate-300 hover:text-white hover:bg-blue-500/10 transition"
                    >
                        Login
                    </a>

                    <a
                        href="register.html"
                        class="main-button px-5 py-2.5 rounded-xl text-sm font-semibold text-white"
                    >
                        <span class="relative z-10">Register</span>
                    </a>
                </div>

                <button
                    id="mobileMenuButton"
                    class="md:hidden text-slate-300"
                    aria-label="Open menu"
                >
                    <svg width="25" height="25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

            </div>

            <div id="mobileMenu" class="hidden md:hidden pb-5">
                <div class="glass-card rounded-2xl p-4 space-y-2">
                    <a href="index.html" class="block px-4 py-3 rounded-xl text-slate-300 hover:bg-blue-500/10">Home</a>
                    <a href="features.html" class="block px-4 py-3 rounded-xl text-blue-400 bg-blue-500/10">Features</a>
                    <a href="ai.coach.html" class="block px-4 py-3 rounded-xl text-slate-300 hover:bg-blue-500/10">AI Coach</a>
                    <a href="goals.html" class="block px-4 py-3 rounded-xl text-slate-300 hover:bg-blue-500/10">Goals</a>
                    <a href="contact.html" class="block px-4 py-3 rounded-xl text-slate-300 hover:bg-blue-500/10">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <main>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-20 pb-24">

            <div class="grid lg:grid-cols-2 gap-14 items-center">

                <div class="reveal">

                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-400/20 mb-6">
                        <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_#3B82F6]"></span>

                        <span class="text-blue-400 text-xs font-semibold tracking-[.22em] uppercase">
                            CAMPUS COIN FEATURES
                        </span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white leading-[1.05]">
                        Powerful
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-500">
                            Features
                        </span>
                    </h1>

                    <p class="mt-7 text-lg text-slate-400 leading-relaxed max-w-xl">
                        Everything you need to track expenses, manage your budget,
                        save toward your goals, and build smarter financial habits.
                    </p>

                    <div class="flex flex-wrap gap-4 mt-8">

                        <a
                            href="#features"
                            class="main-button px-6 py-3.5 rounded-xl text-white font-semibold"
                        >
                            <span class="relative z-10">
                                Explore Features →
                            </span>
                        </a>

                        <a
                            href="register.html"
                            class="px-6 py-3.5 rounded-xl border border-slate-700 bg-slate-900/30 text-slate-300 font-semibold hover:border-blue-500/40 hover:text-white transition"
                        >
                            Get Started
                        </a>

                    </div>

                </div>

                <!-- Robot -->
                <div class="flex justify-center items-center reveal">

                    <div class="relative">

                        <div class="robot-card one rounded-xl px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-blue-400">✦</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 uppercase">Smart</p>
                                    <p class="text-xs font-semibold text-white">AI Coach</p>
                                </div>
                            </div>
                        </div>

                        <div class="robot-card two rounded-xl px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-blue-400">◈</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 uppercase">Plan</p>
                                    <p class="text-xs font-semibold text-white">Budget</p>
                                </div>
                            </div>
                        </div>

                        <div class="robot-card three rounded-xl px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-blue-400">◎</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 uppercase">Track</p>
                                    <p class="text-xs font-semibold text-white">Insights</p>
                                </div>
                            </div>
                        </div>

                        <div class="robot-card four rounded-xl px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-blue-400">◇</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 uppercase">Save</p>
                                    <p class="text-xs font-semibold text-white">Goals</p>
                                </div>
                            </div>
                        </div>

                        <div id="robot" class="robot-wrapper">

                            <div class="robot-antenna">
                                <span class="robot-signal"></span>
                            </div>

                            <div class="robot-head">

                                <div class="robot-ear left">
                                    <span></span>
                                </div>

                                <div class="robot-ear right">
                                    <span></span>
                                </div>

                                <div class="robot-eye left">
                                    <div class="eye-pupil"></div>
                                </div>

                                <div class="robot-eye right">
                                    <div class="eye-pupil"></div>
                                </div>

                                <div class="robot-mouth"></div>

                            </div>

                            <div class="robot-body">

                                <div class="robot-chest">
                                    <div class="core">$</div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!-- Features -->
        <section id="features" class="max-w-7xl mx-auto px-6 lg:px-8 pb-28">

            <div class="text-center max-w-2xl mx-auto mb-14 reveal">

                <div class="flex items-center justify-center gap-2 text-blue-400 text-xs font-semibold tracking-[.22em] uppercase">
                    <span class="w-7 h-px bg-blue-500"></span>
                    Everything Connected
                    <span class="w-7 h-px bg-blue-500"></span>
                </div>

                <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4">
                    Finance tools built for students
                </h2>

                <p class="text-slate-400 mt-4 leading-relaxed">
                    Powerful tools work together to give you a clearer picture
                    of your money and help you make better financial decisions.
                </p>

            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- 1 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        $
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        Expense Tracking
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Keep every transaction organized and instantly understand where your money goes.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6 space-y-3">

                        <div class="flex justify-between items-center">
                            <span class="text-xs text-slate-400">Food</span>
                            <span class="text-xs text-white">-$24.50</span>
                        </div>

                        <div class="mini-bar" style="width:72%;"></div>

                        <div class="flex justify-between items-center">
                            <span class="text-xs text-slate-500">Transport</span>
                            <span class="text-xs text-slate-300">-$12.00</span>
                        </div>

                        <div class="mini-bar opacity-60" style="width:45%;"></div>

                    </div>

                </div>

                <!-- 2 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        ◈
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        Budget Planning
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Set realistic spending limits and stay on track across every category.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6 space-y-4">

                        <div>
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-slate-400">Food</span>
                                <span class="text-blue-400">72%</span>
                            </div>
                            <div class="h-1.5 bg-slate-800 rounded-full">
                                <div class="mini-bar h-full" style="width:72%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-slate-400">Transport</span>
                                <span class="text-blue-400">45%</span>
                            </div>
                            <div class="h-1.5 bg-slate-800 rounded-full">
                                <div class="mini-bar h-full opacity-70" style="width:45%;"></div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- 3 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        ◎
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        Goal Saving
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Turn your plans into measurable goals with progress tracking and milestones.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6">

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-400">Laptop Goal</span>
                            <span class="text-xs text-blue-400">68%</span>
                        </div>

                        <div class="h-2 bg-slate-800 rounded-full mt-3 overflow-hidden">
                            <div class="mini-bar h-full" style="width:68%;"></div>
                        </div>

                        <p class="text-[11px] text-slate-500 mt-3">
                            $680 of $1,000 saved
                        </p>

                    </div>

                </div>

                <!-- 4 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        ✦
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        AI Coach
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Get personalized financial guidance powered by your spending patterns.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6">

                        <div class="flex gap-2">
                            <div class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 text-[9px] flex items-center justify-center">
                                AI
                            </div>

                            <div class="bg-blue-500/10 border border-blue-500/10 rounded-lg px-3 py-2">
                                <p class="text-[10px] text-slate-300">
                                    Save 10% more this month.
                                </p>
                            </div>
                        </div>

                        <div class="mini-line mt-4 w-4/5"></div>
                        <div class="mini-line mt-2 w-3/5"></div>

                    </div>

                </div>

                <!-- 5 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        ▤
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        Reports
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Turn your financial activity into simple reports that reveal meaningful trends.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6">

                        <div class="flex items-end gap-2 h-20">
                            <div class="w-1/6 bg-blue-500/30 rounded-t" style="height:35%;"></div>
                            <div class="w-1/6 bg-blue-500/40 rounded-t" style="height:55%;"></div>
                            <div class="w-1/6 bg-blue-500/50 rounded-t" style="height:45%;"></div>
                            <div class="w-1/6 bg-blue-500/60 rounded-t" style="height:72%;"></div>
                            <div class="w-1/6 bg-blue-500/80 rounded-t" style="height:65%;"></div>
                            <div class="w-1/6 bg-blue-500 rounded-t" style="height:88%;"></div>
                        </div>

                    </div>

                </div>

                <!-- 6 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        ◉
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        Insights
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Discover spending patterns and opportunities hidden inside your financial activity.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6 space-y-3">

                        <div class="rounded-xl border border-blue-500/15 bg-blue-500/5 p-3">
                            <p class="text-[10px] text-blue-400">INSIGHT</p>
                            <p class="text-xs text-slate-300 mt-1">
                                Food spending increased 15%.
                            </p>
                        </div>

                        <div class="rounded-xl border border-blue-500/10 p-3">
                            <p class="text-[10px] text-slate-500">OPPORTUNITY</p>
                            <p class="text-xs text-slate-400 mt-1">
                                Potential savings detected.
                            </p>
                        </div>

                    </div>

                </div>

                <!-- 7 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        87
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        Financial Health Score
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Understand your financial habits through a simple health score and detailed breakdown.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6 flex items-center gap-4">

                        <div class="score-ring">
                            <span class="score-text text-lg font-bold text-white">
                                87
                            </span>
                        </div>

                        <div class="space-y-2 flex-1">
                            <div>
                                <div class="flex justify-between text-[10px] text-slate-500">
                                    <span>Saving</span>
                                    <span>91%</span>
                                </div>
                                <div class="h-1 bg-slate-800 rounded-full mt-1">
                                    <div class="h-full bg-blue-500 rounded-full" style="width:91%;"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-[10px] text-slate-500">
                                    <span>Budget</span>
                                    <span>84%</span>
                                </div>
                                <div class="h-1 bg-slate-800 rounded-full mt-1">
                                    <div class="h-full bg-blue-500 rounded-full" style="width:84%;"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- 8 -->
                <div class="glass-card feature-card rounded-3xl p-6 reveal">

                    <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 text-2xl">
                        ★
                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">
                        Achievements
                    </h3>

                    <p class="text-sm text-slate-400 leading-relaxed mt-3">
                        Stay motivated with milestones, streaks, badges, and financial achievements.
                    </p>

                    <div class="preview rounded-2xl p-4 mt-6">

                        <div class="flex gap-2">

                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                                ★
                            </div>

                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                                ◆
                            </div>

                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                                ✓
                            </div>

                        </div>

                        <p class="text-[11px] text-slate-500 mt-3">
                            12 achievements unlocked
                        </p>

                    </div>

                </div>

            </div>

        </section>

        <!-- CTA -->
        <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-24">

            <div class="glass-card rounded-[32px] overflow-hidden relative reveal">

                <div class="absolute inset-0 bg-blue-500/[.03]"></div>

                <div class="relative p-10 sm:p-14 text-center">

                    <div class="mx-auto w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 text-2xl mb-6">
                        $
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-bold text-white">
                        Ready to take control of your finances?
                    </h2>

                    <p class="text-slate-400 max-w-xl mx-auto mt-4">
                        Start using Campus Coin and build better financial habits
                        one decision at a time.
                    </p>

                    <a
                        href="register.html"
                        class="main-button inline-block mt-8 px-7 py-3.5 rounded-xl text-white font-semibold"
                    >
                        <span class="relative z-10">
                            Get Started →
                        </span>
                    </a>

                </div>

            </div>

        </section>

    </main>

    <!-- Footer -->
     <footer class="border-t border-slate-800/70 bg-[#080C18]/70">
    <div class="max-w-7xl mx-auto px-6 py-10">

    <div class="grid md:grid-cols-3 gap-8 items-center">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center">
                <span class="text-blue-400 font-black text-lg">C</span>
            </div>

            <div>
                <h3 class="text-white font-semibold">Campus Coin</h3>
                <p class="text-xs text-slate-500">
                    Smart Student Finance Platform
                </p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center">
            <p class="text-sm text-slate-400">
                © 2026 Campus Coin. All rights reserved.
            </p>
        </div>

        <!-- Description -->
        <div class="text-center md:text-right">
            <p class="text-sm text-slate-500 leading-relaxed max-w-md ml-auto">
                Empowering students to save smarter, achieve financial goals,
                and build better money habits through a secure and innovative
                digital campus ecosystem.
            </p>

            <p class="text-xs text-slate-600 mt-2">
                Built with love for students, educators, and future financial leaders.
            </p>
        </div>

    </div>

</div>


</footer>
    <script>
        /* Mobile menu */
        const mobileMenuButton =
            document.getElementById("mobileMenuButton");

        const mobileMenu =
            document.getElementById("mobileMenu");

        mobileMenuButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });


        /* Robot eyes follow cursor */
        const pupils =
            document.querySelectorAll(".eye-pupil");

        document.addEventListener("mousemove", (event) => {

            pupils.forEach((pupil) => {

                const eye = pupil.parentElement;
                const rect = eye.getBoundingClientRect();

                const centerX =
                    rect.left + rect.width / 2;

                const centerY =
                    rect.top + rect.height / 2;

                const deltaX =
                    event.clientX - centerX;

                const deltaY =
                    event.clientY - centerY;

                const angle =
                    Math.atan2(deltaY, deltaX);

                const distance =
                    Math.min(
                        10,
                        Math.hypot(deltaX, deltaY) / 7
                    );

                const x =
                    Math.cos(angle) * distance;

                const y =
                    Math.sin(angle) * distance;

                pupil.style.transform =
                    `translate3d(${x}px, ${y}px, 0)`;
            });

        });


        /* Scroll reveal */
        const revealElements =
            document.querySelectorAll(".reveal");

        const revealObserver =
            new IntersectionObserver(
                (entries) => {

                    entries.forEach((entry) => {

                        if (entry.isIntersecting) {
                            entry.target.classList.add("visible");
                        }

                    });

                },
                {
                    threshold: .12
                }
            );

        revealElements.forEach((element) => {
            revealObserver.observe(element);
        });


        /* Initial reveal for hero */
        setTimeout(() => {

            document
                .querySelectorAll(".reveal")
                .forEach((element, index) => {

                    if (
                        element.getBoundingClientRect().top
                        < window.innerHeight
                    ) {
                        setTimeout(() => {
                            element.classList.add("visible");
                        }, index * 100);
                    }

                });

        }, 100);
    </script>

    <script src="theme-toggle.js"></script>
</body>
</html>
