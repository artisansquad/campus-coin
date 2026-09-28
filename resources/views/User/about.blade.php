<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Coin — About</title>

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
            min-height: 100vh;

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: #E2E8F0;

            background:
                radial-gradient(
                    circle at 12% 12%,
                    rgba(59, 130, 246, .15),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 88% 42%,
                    rgba(59, 130, 246, .09),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(37, 99, 235, .08),
                    transparent 35%
                ),
                #0A0F1E;

            overflow-x: hidden;
        }

        /* =========================
           BACKGROUND
        ========================= */

        .grid-bg {
            position: fixed;
            inset: 0;
            z-index: -5;
            pointer-events: none;
            opacity: .16;

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
                    transparent 92%
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
            background: #2563EB;
        }

        /* =========================
           PARTICLES
        ========================= */

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

            animation:
                particleFloat 9s
                infinite
                ease-in-out;

            z-index: -2;
        }

        .particle:nth-of-type(2) {
            animation-delay: -2s;
        }

        .particle:nth-of-type(3) {
            animation-delay: -4s;
        }

        .particle:nth-of-type(4) {
            animation-delay: -6s;
        }

        .particle:nth-of-type(5) {
            animation-delay: -3s;
        }

        @keyframes particleFloat {
            0%, 100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(25px, -70px);
            }
        }

        /* =========================
           NAVIGATION
        ========================= */

        
        /* =========================
           GLASSMORPHISM
        ========================= */

        .glass-card {
            background:
                rgba(27, 42, 65, .78);

            border:
                1px solid
                rgba(148, 163, 184, .15);

            box-shadow:
                0 35px 90px
                rgba(0, 0, 0, .32),

                inset 0 1px 0
                rgba(255, 255, 255, .025);

            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .glass-card-hover {
            transition:
                transform .3s ease,
                border-color .3s ease,
                box-shadow .3s ease;
        }

        .glass-card-hover:hover {
            transform: translateY(-7px);

            border-color:
                rgba(59, 130, 246, .35);

            box-shadow:
                0 30px 80px
                rgba(0, 0, 0, .36),

                0 0 35px
                rgba(59, 130, 246, .08),

                inset 0 1px 0
                rgba(255, 255, 255, .04);
        }

        /* =========================
           BUTTON
        ========================= */

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
                    rgba(255, 255, 255, .15),
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

        /* =========================
           ROBOT MASCOT
        ========================= */

        .robot-wrapper {
            position: relative;

            width: 250px;

            animation:
                robotFloat 4s
                ease-in-out
                infinite;
        }

        @keyframes robotFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
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
                0 25px 60px
                rgba(0, 0, 0, .35),

                0 0 45px
                rgba(59, 130, 246, .12),

                inset 0 1px 0
                rgba(255, 255, 255, .05);

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
                0 0 25px
                rgba(59, 130, 246, .35);

            animation:
                signalPulse 1.6s
                infinite;
        }

        @keyframes signalPulse {
            0%, 100% {
                transform:
                    translateX(-50%)
                    scale(1);

                opacity: 1;
            }

            50% {
                transform:
                    translateX(-50%)
                    scale(.65);

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

            border:
                1px solid
                rgba(59, 130, 246, .45);
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

            border:
                1px solid
                rgba(59, 130, 246, .8);

            overflow: hidden;

            box-shadow:
                0 0 20px
                rgba(59, 130, 246, .16);
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

            transition:
                transform .08s linear;
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

            margin:
                -4px auto 0;

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
                0 25px 50px
                rgba(0, 0, 0, .30);
        }

        .robot-chest {
            position: absolute;

            width: 72px;
            height: 72px;

            left: 50%;
            top: 21px;

            transform:
                translateX(-50%);

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
                0 0 18px
                rgba(59, 130, 246, .35),

                0 8px 25px
                rgba(59, 130, 246, .20);

            animation:
                corePulse 2s
                infinite;
        }

        @keyframes corePulse {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        /* =========================
           ICON BOX
        ========================= */

        .icon-box {
            width: 52px;
            height: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 15px;

            background:
                rgba(59, 130, 246, .10);

            border:
                1px solid
                rgba(59, 130, 246, .22);

            color: #60A5FA;

            box-shadow:
                0 0 22px
                rgba(59, 130, 246, .05);
        }

        /* =========================
           ROADMAP
        ========================= */

        .roadmap-line {
            position: absolute;

            top: 31px;
            left: 12.5%;

            width: 75%;
            height: 1px;

            background:
                linear-gradient(
                    90deg,
                    rgba(59, 130, 246, .15),
                    rgba(59, 130, 246, .55),
                    rgba(59, 130, 246, .15)
                );
        }

        .roadmap-dot {
            position: relative;
            z-index: 2;

            width: 62px;
            height: 62px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #0A0F1E;

            border:
                1px solid
                rgba(59, 130, 246, .55);

            color: #60A5FA;

            box-shadow:
                0 0 25px
                rgba(59, 130, 246, .12);
        }

        /* =========================
           SCROLL REVEAL
        ========================= */

        .reveal {
            opacity: 0;

            transform:
                translateY(30px);

            transition:
                opacity .75s ease,
                transform .75s ease;
        }

        .reveal.visible {
            opacity: 1;

            transform:
                translateY(0);
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 900px) {

            .robot-wrapper {
                transform: scale(.85);
            }

            .roadmap-line {
                display: none;
            }

        }

        @media(max-width: 600px) {

            .robot-wrapper {
                transform: scale(.72);

                margin-top: -20px;
                margin-bottom: -35px;
            }

        }

        :root {
            color-scheme: dark;
            --page-bg: #0A0F1E;
            --panel-bg: #ffffff;
            --soft-panel: #f8fafc;
            --card-bg: #1B2A41;
            --card-border: rgba(148, 163, 184, 0.15);
            --text: #E2E8F0;
            --text-strong: #ffffff;
            --muted: #94A3B8;
            --link: #60A5FA;
            --track-bg: rgba(15, 23, 42, 0.72);
            --track-border: rgba(148, 163, 184, 0.18);
            --toggle-active: #3B82F6;
            --shadow: rgba(0, 0, 0, 0.28);
        }

        :root[data-theme="light"] {
            color-scheme: light;
            --page-bg: #f4f7fb;
            --panel-bg: #ffffff;
            --soft-panel: #edf4ff;
            --card-bg: #ffffff;
            --card-border: rgba(15, 23, 42, 0.08);
            --text: #0f172a;
            --text-strong: #0f172a;
            --muted: #475569;
            --link: #2563eb;
            --track-bg: rgba(255, 255, 255, 0.86);
            --track-border: rgba(148, 163, 184, 0.32);
            --toggle-active: #3B82F6;
            --shadow: rgba(15, 23, 42, 0.10);
        }

        body {
            background: var(--page-bg) !important;
            color: var(--text) !important;
            transition: background 0.2s ease, color 0.2s ease;
        }

        body[data-theme="light"] .navbar,
        body[data-theme="light"] .top-nav,
        body[data-theme="light"] .glass-card,
        body[data-theme="light"] .card,
        body[data-theme="light"] .panel,
        body[data-theme="light"] .feature-card,
        body[data-theme="light"] .summary-card,
        body[data-theme="light"] .stat-card,
        body[data-theme="light"] .input-field,
        body[data-theme="light"] .input-dark,
        body[data-theme="light"] .sidebar,
        body[data-theme="light"] .mobile-menu,
        body[data-theme="light"] .setting-row,
        body[data-theme="light"] .table-card,
        body[data-theme="light"] .topbar {
            background: var(--panel-bg) !important;
            border-color: var(--card-border) !important;
            box-shadow: 0 18px 40px var(--shadow) !important;
        }

        body[data-theme="light"] .text-slate-400,
        body[data-theme="light"] .text-slate-500,
        body[data-theme="light"] .text-slate-300,
        body[data-theme="light"] .text-slate-200,
        body[data-theme="light"] .text-slate-600,
        body[data-theme="light"] .text-gray-400,
        body[data-theme="light"] .muted,
        body[data-theme="light"] .text-slate-700 {
            color: var(--muted) !important;
        }

        body[data-theme="light"] .text-white,
        body[data-theme="light"] h1,
        body[data-theme="light"] h2,
        body[data-theme="light"] h3,
        body[data-theme="light"] h4,
        body[data-theme="light"] h5,
        body[data-theme="light"] h6,
        body[data-theme="light"] .font-bold,
        body[data-theme="light"] .text-slate-100 {
            color: var(--text-strong) !important;
        }

        body[data-theme="light"] .nav-link,
        body[data-theme="light"] .menu-link,
        body[data-theme="light"] a,
        body[data-theme="light"] .text-slate-300,
        body[data-theme="light"] .text-slate-200 {
            color: var(--text) !important;
        }

        body[data-theme="light"] .theme-switcher {
            background: var(--track-bg);
            border-color: var(--track-border);
        }

        .theme-switcher {
            position: fixed;
            top: 18px;
            right: 20px;
            z-index: 1000;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 12px 28px rgba(2, 6, 23, 0.2);
            backdrop-filter: blur(10px);
        }

        .theme-option {
            width: 34px;
            height: 30px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: #94A3B8;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .theme-option svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
        }

        .theme-option.active {
            background: var(--toggle-active);
            color: white;
            box-shadow: 0 8px 18px rgba(59, 130, 246, 0.35);
        }

        @media (max-width: 640px) {
            .theme-switcher {
                top: 12px;
                right: 12px;
            }
        }
    </style>
</head>


<body>

    <!-- Background -->

    <div class="grid-bg"></div>

    <div class="ambient one"></div>
    <div class="ambient two"></div>

    <div class="particle" style="left:8%;top:22%;"></div>
    <div class="particle" style="left:20%;top:75%;"></div>
    <div class="particle" style="left:82%;top:18%;"></div>
    <div class="particle" style="left:92%;top:70%;"></div>
    <div class="particle" style="left:65%;top:8%;"></div>
    <div class="particle" style="left:47%;top:40%;"></div>


    <!-- =========================
         NAVIGATION
    ========================== -->

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


    <main>


        <!-- =========================
             HERO
        ========================== -->

        <section
            class="max-w-7xl
                   mx-auto
                   px-6
                   pt-20
                   pb-28"
        >

            <div
                class="grid
                       lg:grid-cols-[1.05fr_.95fr]
                       gap-14
                       items-center"
            >

                <div class="reveal">

                    <div
                        class="inline-flex
                               items-center
                               gap-2
                               px-3
                               py-1.5
                               rounded-full
                               bg-blue-500/10
                               border border-blue-400/20
                               mb-6"
                    >

                        <span
                            class="w-2
                                   h-2
                                   rounded-full
                                   bg-blue-500
                                   shadow-[0_0_10px_#3B82F6]"
                        ></span>

                        <span
                            class="text-blue-400
                                   text-xs
                                   font-semibold
                                   tracking-[.22em]
                                   uppercase"
                        >
                            About
                        </span>

                    </div>


                    <h1
                        class="text-5xl
                               sm:text-6xl
                               lg:text-7xl
                               font-bold
                               tracking-tight
                               leading-[1.05]
                               text-white"
                    >

                        Your story,
                        <span
                            class="text-transparent
                                   bg-clip-text
                                   bg-gradient-to-r
                                   from-blue-400
                                   to-blue-500"
                        >
                            your vision
                        </span>

                        <br>

                        your way.

                    </h1>


                    <p
                        class="max-w-2xl
                               text-lg
                               leading-8
                               text-slate-400
                               mt-7"
                    >
                        This page is intentionally clear so you can add the
                        real message, values, and details that belong to your
                        product or brand.
                    </p>


                    <div
                        class="flex
                               flex-wrap
                               items-center
                               gap-4
                               mt-9"
                    >

                        
                        
                             <a href="features.html" class="main-button inline-flex items-center justify-center px-8 py-3.5 rounded-xl text-white font-semibold mt-8">
                        <span class="relative z-10">Learn More →</span>
                    </a>
                        

                    </div>

                </div>

                <div class="flex justify-center lg:justify-end reveal">

                    <div class="robot-wrapper">

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

                                <div class="core">
                                    ?
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================
             MISSION
        ========================== -->

        <section
            id="mission"
            class="max-w-7xl
                   mx-auto
                   px-6
                   pb-24"
        >

            <div
                class="glass-card
                       rounded-[30px]
                       p-8
                       sm:p-12
                       reveal"
            >

                <div
                    class="grid
                           lg:grid-cols-[.75fr_1.25fr]
                           gap-10
                           items-center"
                >

                    <div>

                        <div class="icon-box">

                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <path d="M12 3v18" />
                                <path d="M17 7.5c0-2-2.2-3.5-5-3.5s-5 1.5-5 3.5 2.2 3.5 5 3.5 5 1.5 5 3.5-2.2 3.5-5 3.5-5-1.5-5-3.5" />
                            </svg>

                        </div>

                        <p
                            class="text-blue-400
                                   text-xs
                                   font-semibold
                                   tracking-[.22em]
                                   uppercase
                                   mt-6"
                        >
                            Our mission
                        </p>

                        <h2
                            class="text-3xl
                                   sm:text-4xl
                                   font-bold
                                   text-white
                                   mt-2"
                        >
                            Define what matters most.
                        </h2>

                    </div>

                    <div>

                        <p
                            class="text-lg
                                   leading-8
                                   text-slate-400"
                        >
                            Add your mission statement here. This section is
                            meant to describe the purpose behind your product,
                            service, or business and why it exists.
                        </p>

                        <p
                            class="text-slate-500
                                   leading-7
                                   mt-5"
                        >
                            Replace this placeholder with the real story,
                            goals, and principles that guide your work.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================
             VISION
        ========================== -->

        <section
            class="max-w-7xl
                   mx-auto
                   px-6
                   pb-24"
        >

            <div
                class="grid
                       lg:grid-cols-2
                       gap-6"
            >

                <div
                    class="glass-card
                           glass-card-hover
                           rounded-[30px]
                           p-8
                           sm:p-10
                           reveal"
                >

                    <div class="icon-box">

                        <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M3 12h18"></path>
                            <path d="M12 3c2.5 2.7 3.5 5.7 3.5 9s-1 6.3-3.5 9"></path>
                            <path d="M12 3c-2.5 2.7-3.5 5.7-3.5 9s1 6.3 3.5 9"></path>
                        </svg>

                    </div>

                    <p
                        class="text-blue-400
                               text-xs
                               font-semibold
                               tracking-[.22em]
                               uppercase
                               mt-7"
                    >
                        Our vision
                    </p>

                    <h2
                        class="text-3xl
                               font-bold
                               text-white
                               mt-2"
                    >
                        A better future built around purpose.
                    </h2>

                    <p
                        class="text-slate-400
                               leading-7
                               mt-5"
                    >
                        Use this space to describe the future you want to
                        create, the impact you want to make, and the change
                        your work is meant to bring.
                    </p>

                </div>


                <div
                    class="glass-card
                           glass-card-hover
                           rounded-[30px]
                           p-8
                           sm:p-10
                           reveal"
                >

                    <div class="h-full flex flex-col justify-center">

                        <p class="text-slate-500 text-sm uppercase tracking-[.2em]">
                            The idea
                        </p>

                        <p class="text-2xl sm:text-3xl font-semibold leading-relaxed text-white mt-5">
                            A clear purpose, a meaningful plan, and a better
                            experience for everyone involved.
                        </p>

                        <div class="w-16 h-1 rounded-full bg-blue-500 mt-7 shadow-[0_0_14px_rgba(59,130,246,.5)]"></div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================
             WHY THIS PAGE
        ========================== -->

        <section
            class="max-w-7xl
                   mx-auto
                   px-6
                   pb-24"
        >

            <div class="text-center reveal">

                <p
                    class="text-blue-400
                           text-xs
                           font-semibold
                           tracking-[.22em]
                           uppercase"
                >
                    Why this page
                </p>

                <h2
                    class="text-3xl
                           sm:text-4xl
                           font-bold
                           text-white
                           mt-2"
                >
                    Share the value behind your work.
                </h2>

                <p
                    class="max-w-2xl
                           mx-auto
                           text-slate-400
                           mt-4
                           leading-7"
                >
                    This area can explain what makes your company,
                    product, or service useful and why people should care.
                </p>

            </div>

            <div class="grid md:grid-cols-3 gap-6 mt-10">

                <div class="glass-card glass-card-hover rounded-3xl p-7 reveal">

                    <div class="icon-box">

                        <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <path d="M7 9h10"></path>
                            <path d="M7 13h5"></path>
                            <circle cx="17" cy="14" r="1"></circle>
                        </svg>

                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">Feature one</h3>

                    <p class="text-slate-400 leading-7 mt-3">
                        Describe your first core strength, capability, or
                        solution in a way that feels clear and valuable.
                    </p>

                    <div class="mt-6 text-sm text-blue-400">
                        Add your value →
                    </div>

                </div>

                <div class="glass-card glass-card-hover rounded-3xl p-7 reveal">

                    <div class="icon-box">

                        <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path d="M19 8h1a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-1"></path>
                            <path d="M5 8h11a3 3 0 0 1 3 3v4a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-4a3 3 0 0 1 3-3Z"></path>
                            <path d="M6 5h7"></path>
                            <path d="M8 3h4"></path>
                        </svg>

                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">Feature two</h3>

                    <p class="text-slate-400 leading-7 mt-3">
                        Add another reason people choose your product and
                        explain how it improves the experience.
                    </p>

                    <div class="mt-6 text-sm text-blue-400">
                        Highlight it clearly →
                    </div>

                </div>

                <div class="glass-card glass-card-hover rounded-3xl p-7 reveal">

                    <div class="icon-box">

                        <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <rect x="4" y="4" width="16" height="16" rx="4"></rect>
                            <circle cx="9" cy="11" r="1.5"></circle>
                            <circle cx="15" cy="11" r="1.5"></circle>
                            <path d="M8 15c1.2 1.2 2.5 1.8 4 1.8s2.8-.6 4-1.8"></path>
                            <path d="M12 1v3"></path>
                        </svg>

                    </div>

                    <h3 class="text-xl font-bold text-white mt-6">Feature three</h3>

                    <p class="text-slate-400 leading-7 mt-3">
                        Use this section to explain the final benefit or
                        differentiator your audience should remember.
                    </p>

                    <div class="mt-6 text-sm text-blue-400">
                        Keep it focused →
                    </div>

                </div>

            </div>

        </section>


        <!-- =========================
             ROADMAP
        ========================= -->

        <section class="max-w-7xl mx-auto px-6 pb-28">

            <div class="glass-card rounded-[32px] p-8 sm:p-12 reveal">

                <div class="text-center">

                    <p class="text-blue-400 text-xs font-semibold tracking-[.22em] uppercase">
                        Roadmap
                    </p>

                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-2">
                        Your next steps.
                    </h2>

                    <p class="max-w-2xl mx-auto text-slate-400 mt-4 leading-7">
                        Add upcoming milestones, product goals, or future
                        plans here without hardcoding any final messaging.
                    </p>

                </div>

                <div class="relative grid md:grid-cols-3 gap-8 mt-14">

                    <div class="roadmap-line"></div>

                    <div class="relative text-center reveal">

                        <div class="roadmap-dot mx-auto">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M12 3v4"></path>
                                <rect x="5" y="7" width="14" height="12" rx="3"></rect>
                                <circle cx="9" cy="12" r="1"></circle>
                                <circle cx="15" cy="12" r="1"></circle>
                                <path d="M9 16h6"></path>
                            </svg>

                        </div>

                        <p class="text-blue-400 text-xs uppercase tracking-[.2em] mt-6">
                            Step one
                        </p>

                        <h3 class="text-xl font-bold text-white mt-2">Foundation</h3>

                        <p class="text-sm leading-6 text-slate-500 mt-3 max-w-xs mx-auto">
                            Outline the first milestone and what needs to be
                            built or clarified.
                        </p>

                    </div>

                    <div class="relative text-center reveal">

                        <div class="roadmap-dot mx-auto">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <circle cx="12" cy="12" r="8"></circle>
                                <circle cx="12" cy="12" r="4"></circle>
                                <circle cx="12" cy="12" r="1" fill="currentColor"></circle>
                            </svg>

                        </div>

                        <p class="text-blue-400 text-xs uppercase tracking-[.2em] mt-6">
                            Step two
                        </p>

                        <h3 class="text-xl font-bold text-white mt-2">Growth</h3>

                        <p class="text-sm leading-6 text-slate-500 mt-3 max-w-xs mx-auto">
                            Add your next phase, whether that is expansion,
                            improvement, or refinement.
                        </p>

                    </div>

                    <div class="relative text-center reveal">

                        <div class="roadmap-dot mx-auto">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M4 19V5"></path>
                                <path d="M4 19h17"></path>
                                <path d="M7 15l4-4 3 2 5-6"></path>
                            </svg>

                        </div>

                        <p class="text-blue-400 text-xs uppercase tracking-[.2em] mt-6">
                            Step three
                        </p>

                        <h3 class="text-xl font-bold text-white mt-2">Impact</h3>

                        <p class="text-sm leading-6 text-slate-500 mt-3 max-w-xs mx-auto">
                            Summarize the long-term outcome and value you want
                            to deliver.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================
             CTA
        ========================== -->

        <section id="get-started" class="max-w-7xl mx-auto px-6 pb-24">

            <div class="glass-card rounded-[32px] p-8 sm:p-14 text-center relative overflow-hidden reveal">

                <div class="absolute w-80 h-80 rounded-full bg-blue-500/10 blur-3xl left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"></div>

                <div class="relative z-10">

                   

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                        Ready to tell your story?
                    </h2>

                    <p class="max-w-xl mx-auto text-slate-400 mt-5 leading-7">
                        Replace this final call-to-action with your real
                        invitation, offer, or action.
                    </p>

                    <a href="register.html" class="main-button inline-flex items-center justify-center px-8 py-3.5 rounded-xl text-white font-semibold mt-8">
                        <span class="relative z-10">Get started →</span>
                    </a>

                </div>

            </div>

        </section>

    </main>


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


    <!-- =========================
         JAVASCRIPT
    ========================== -->

    <script>

        /* =========================
           SCROLL REVEAL
        ========================== */

        const revealElements =
            document.querySelectorAll(".reveal");


        const revealObserver =
            new IntersectionObserver(
                function(entries) {

                    entries.forEach(function(entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add(
                                "visible"
                            );

                            revealObserver.unobserve(
                                entry.target
                            );
                        }

                    });

                },
                {
                    threshold: 0.12
                }
            );


        revealElements.forEach(function(element) {

            revealObserver.observe(element);

        });


        /* =========================
           ROBOT EYE TRACKING
        ========================== */

        const pupils =
            document.querySelectorAll(".eye-pupil");


        document.addEventListener(
            "mousemove",
            function(event) {

                pupils.forEach(function(pupil) {

                    const eye =
                        pupil.parentElement;

                    const rect =
                        eye.getBoundingClientRect();

                    const eyeCenterX =
                        rect.left +
                        rect.width / 2;

                    const eyeCenterY =
                        rect.top +
                        rect.height / 2;

                    const deltaX =
                        event.clientX -
                        eyeCenterX;

                    const deltaY =
                        event.clientY -
                        eyeCenterY;

                    const angle =
                        Math.atan2(
                            deltaY,
                            deltaX
                        );

                    const maxDistance = 9;

                    const distance =
                        Math.min(
                            maxDistance,
                            Math.hypot(
                                deltaX,
                                deltaY
                            ) / 6
                        );

                    const x =
                        Math.cos(angle) *
                        distance;

                    const y =
                        Math.sin(angle) *
                        distance;

                    pupil.style.transform =
                        `translate3d(${x}px, ${y}px, 0)`;

                });

            }
        );


        /* =========================
           ROBOT BUTTON REACTION
        ========================== */

        const robot =
            document.querySelector(".robot-wrapper");


        document
            .querySelectorAll("button, a")
            .forEach(function(element) {

                element.addEventListener(
                    "mouseenter",
                    function() {

                        robot.style.animationDuration =
                            "2.8s";

                    }
                );


                element.addEventListener(
                    "mouseleave",
                    function() {

                        robot.style.animationDuration =
                            "4s";

                    }
                );

            });


        /* =========================
           THEME TOGGLE
        ========================== */

        (function () {
            const key = 'campuscoin-theme';
            const root = document.documentElement;
            const media = window.matchMedia('(prefers-color-scheme: dark)');

            function applyTheme(mode) {
                const isDark = mode === 'dark' || (mode === 'system' && media.matches);
                const nextTheme = isDark ? 'dark' : 'light';
                root.setAttribute('data-theme', nextTheme);
                document.body && document.body.setAttribute('data-theme', nextTheme);

                document.querySelectorAll('.theme-option').forEach(function (button) {
                    const active = button.dataset.themeOption === mode;
                    button.classList.toggle('active', active);
                    button.setAttribute('aria-pressed', String(active));
                });
            }

            try {
                const saved = localStorage.getItem(key) || 'system';
                applyTheme(saved);

                document.querySelectorAll('.theme-option').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const mode = button.dataset.themeOption;
                        localStorage.setItem(key, mode);
                        applyTheme(mode);
                    });
                });

                if (media.addEventListener) {
                    media.addEventListener('change', function () {
                        if ((localStorage.getItem(key) || 'system') === 'system') {
                            applyTheme('system');
                        }
                    });
                } else if (media.addListener) {
                    media.addListener(function () {
                        if ((localStorage.getItem(key) || 'system') === 'system') {
                            applyTheme('system');
                        }
                    });
                }
            } catch (error) {
                applyTheme('system');
            }
        })();
    </script>

  

</body>

</html>
