<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Coin — Student Finance</title>

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
                    circle at 15% 15%,
                    rgba(59, 130, 246, .14),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 85% 80%,
                    rgba(59, 130, 246, .10),
                    transparent 30%
                ),
                #0A0F1E;

            overflow-x: hidden;
        }

        /* =========================================
           BACKGROUND
        ========================================= */

        .grid-bg {
            position: fixed;
            inset: 0;
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
                    transparent 90%
                );

            z-index: -5;
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

        /* =========================================
           NAVBAR
        ========================================= */

        .navbar {
            background:
                rgba(10, 15, 30, .72);

            border:
                1px solid
                rgba(148, 163, 184, .12);

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);

            box-shadow:
                0 20px 50px
                rgba(0, 0, 0, .18);
        }

        .nav-link {
            position: relative;
            color: #94A3B8;
            transition: .25s;
        }

        .nav-link:hover {
            color: #E2E8F0;
        }

        .nav-link::after {
            content: "";

            position: absolute;
            width: 0;
            height: 2px;

            left: 50%;
            bottom: -8px;

            transform:
                translateX(-50%);

            background:
                #3B82F6;

            box-shadow:
                0 0 12px
                rgba(59, 130, 246, .7);

            transition:
                width .25s ease;
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .logo-mark {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                rgba(59, 130, 246, .10);

            border:
                1px solid
                rgba(59, 130, 246, .25);

            color:
                #3B82F6;

            box-shadow:
                0 0 20px
                rgba(59, 130, 246, .10);
        }

        .mobile-menu {
            background:
                rgba(10, 15, 30, .96);

            border-top:
                1px solid
                rgba(148, 163, 184, .10);
        }

        /* =========================================
           ROBOT
           SAME STYLE AS PROVIDED THEME
        ========================================= */

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

            transform:
                translateX(-50%);

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

            transform:
                translateX(-50%);

            border-radius: 50%;
            background: #3B82F6;

            box-shadow:
                0 0 10px #3B82F6,
                0 0 25px
                rgba(59, 130, 246, .35);

            animation:
                signalPulse 1.6s infinite;
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

            background:
                #142238;

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

            background:
                #0A0F1E;

            border:
                1px solid
                rgba(59, 130, 246, .8);

            overflow: hidden;

            box-shadow:
                0 0 20px
                rgba(59, 130, 246, .16);

            transition:
                height .25s ease,
                border-radius .25s ease,
                transform .25s ease;
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
                0 0 12px
                #3B82F6;

            transform:
                translate3d(0, 0, 0);

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
                corePulse 2s infinite;
        }

        @keyframes corePulse {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        /* =========================================
           HERO
        ========================================= */

        .hero-glow {
            position: absolute;
            width: 420px;
            height: 420px;

            border-radius: 50%;

            background:
                rgba(59, 130, 246, .12);

            filter: blur(100px);

            animation:
                heroGlow 5s ease-in-out infinite;
        }

        @keyframes heroGlow {
            0%, 100% {
                opacity: .45;
                transform: scale(1);
            }

            50% {
                opacity: .75;
                transform: scale(1.12);
            }
        }

        .gradient-text {
            background:
                linear-gradient(
                    90deg,
                    #E2E8F0,
                    #60A5FA,
                    #3B82F6
                );

            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-title {
            text-shadow:
                0 0 35px
                rgba(59, 130, 246, .10);
        }

        /* =========================================
           BUTTONS
        ========================================= */

        .primary-button {
            position: relative;
            overflow: hidden;

            background:
                #3B82F6;

            box-shadow:
                0 10px 30px
                rgba(59, 130, 246, .18);

            transition: .25s;
        }

        .primary-button::before {
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
                    rgba(255,255,255,.15),
                    transparent
                );

            transform:
                skewX(-20deg);

            transition: .6s;
        }

        .primary-button:hover::before {
            left: 140%;
        }

        .primary-button:hover {
            transform:
                translateY(-2px);

            background:
                #2563EB;

            box-shadow:
                0 15px 35px
                rgba(59, 130, 246, .28);
        }

        .secondary-button {
            border:
                1px solid
                rgba(148, 163, 184, .15);

            background:
                rgba(27, 42, 65, .55);

            transition: .25s;
        }

        .secondary-button:hover {
            transform:
                translateY(-2px);

            border-color:
                rgba(59, 130, 246, .4);

            background:
                rgba(59, 130, 246, .08);

            box-shadow:
                0 10px 30px
                rgba(59, 130, 246, .08);
        }

        /* =========================================
           FLOATING HERO CARDS
        ========================================= */

        .floating-card {
            position: absolute;

            background:
                rgba(27, 42, 65, .88);

            border:
                1px solid
                rgba(148, 163, 184, .14);

            backdrop-filter:
                blur(15px);

            box-shadow:
                0 20px 45px
                rgba(0, 0, 0, .25),

                0 0 20px
                rgba(59, 130, 246, .06);

            animation:
                floatingCard 4s ease-in-out infinite;
        }

        .floating-card:nth-child(2) {
            animation-delay: 1s;
        }

        .floating-card:nth-child(3) {
            animation-delay: 2s;
        }

        .floating-card:nth-child(4) {
            animation-delay: 1.5s;
        }

        @keyframes floatingCard {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        /* =========================================
           SECTION CARDS
        ========================================= */

        .feature-card {
            background:
                rgba(27, 42, 65, .62);

            border:
                1px solid
                rgba(148, 163, 184, .12);

            backdrop-filter:
                blur(16px);

            box-shadow:
                0 20px 45px
                rgba(0, 0, 0, .18);

            transition:
                transform .3s,
                border-color .3s,
                box-shadow .3s;
        }

        .feature-card:hover {
            transform:
                translateY(-7px);

            border-color:
                rgba(59, 130, 246, .35);

            box-shadow:
                0 25px 60px
                rgba(0, 0, 0, .28),

                0 0 25px
                rgba(59, 130, 246, .08);
        }

        .icon-box {
            width: 50px;
            height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background:
                rgba(59, 130, 246, .10);

            border:
                1px solid
                rgba(59, 130, 246, .20);

            color:
                #60A5FA;
        }

        /* =========================================
           STATS
        ========================================= */

        .stat-card {
            background:
                rgba(27, 42, 65, .48);

            border:
                1px solid
                rgba(148, 163, 184, .10);

            transition: .3s;
        }

        .stat-card:hover {
            border-color:
                rgba(59, 130, 246, .30);

            transform:
                translateY(-4px);

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, .22);
        }

        /* =========================================
           REVEAL
        ========================================= */

        .reveal {
            opacity: 0;
            transform: translateY(30px);

            transition:
                opacity .8s ease,
                transform .8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* =========================================
           RESPONSIVE
        ========================================= */

        @media(max-width: 1024px) {
            .hero-robot-area {
                min-height: 540px;
            }
        }

        @media(max-width: 640px) {
            .hero-title {
                font-size: 2.8rem;
            }

            .robot-wrapper {
                transform: scale(.82);
            }

            .hero-robot-area {
                min-height: 430px;
            }

            .floating-card {
                transform: scale(.85);
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
    <div class="particle" style="left:44%;top:30%;"></div>
    <div class="particle" style="left:72%;top:55%;"></div>


    <!-- =========================================
         NAVBAR
    ========================================= -->

    <header class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 pt-4">

        <nav
            class="navbar max-w-7xl mx-auto rounded-2xl px-4 sm:px-6 py-3"
        >

            <div class="flex items-center justify-between">

                <!-- Logo -->

                <a href="index.html" class="flex items-center gap-3">

                    <div class="logo-mark">
                        <span class="font-bold text-lg">$</span>
                    </div>

                    <div>
                        <div class="font-bold text-white">
                            Campus Coin
                        </div>

                        <div
                            class="text-[9px]
                                   uppercase
                                   tracking-[.22em]
                                   text-slate-500"
                        >
                            Student Finance
                        </div>
                    </div>

                </a>


                <!-- Desktop Navigation -->

                <div class="hidden md:flex items-center gap-8">

                    <a href="/" class="nav-link text-sm">
                        Home
                    </a>

                    <a href="features.html" class="nav-link text-sm">
                        Features
                    </a>

                    <a href="about.html" class="nav-link text-sm">
                        About
                    </a>

                    <a href="faq.html" class="nav-link text-sm">
                        Privacy & Policy
                    </a>

                    <a href="contact.html" class="nav-link text-sm">
                        Contact
                    </a>

                </div>


                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a
                            href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                            class="primary-button
                                   rounded-xl
                                   px-5
                                   py-2.5
                                   text-sm
                                   font-semibold
                                   text-white
                                   flex items-center gap-2"
                        >
                            <span class="relative z-10 flex items-center gap-2">
                                <span>Go to Dashboard</span>
                                <span>&rarr;</span>
                            </span>
                        </a>
                    @else
                        <a
                            href="login.html"
                            class="text-sm
                                   text-slate-300
                                   hover:text-white
                                   transition
                                   px-4
                                   py-2"
                        >
                            Login
                        </a>

                        <a
                            href="register.html"
                            class="primary-button
                                   rounded-xl
                                   px-5
                                   py-2.5
                                   text-sm
                                   font-semibold
                                   text-white"
                        >
                            <span class="relative z-10">
                                Register
                            </span>
                        </a>
                    @endauth
                </div>


                <!-- Mobile Button -->

                <button
                    id="mobileMenuButton"
                    class="md:hidden
                           w-10
                           h-10
                           rounded-xl
                           border
                           border-slate-700
                           text-slate-300"
                >
                    ☰
                </button>

            </div>


            <!-- Mobile Menu -->

            <div
                id="mobileMenu"
                class="mobile-menu
                       hidden
                       mt-4
                       -mx-4
                       px-4
                       pb-4
                       pt-3"
            >

                <div class="flex flex-col gap-2">

                    <a
                        href="index.html"
                        class="px-4 py-3 rounded-xl hover:bg-blue-500/10"
                    >
                        Home
                    </a>

                    <a
                        href="features.html"
                        class="px-4 py-3 rounded-xl hover:bg-blue-500/10"
                    >
                        Features
                    </a>

                    <a
                        href="ai.coach.html"
                        class="px-4 py-3 rounded-xl hover:bg-blue-500/10"
                    >
                        AI Coach
                    </a>

                    <a
                        href="goals.html"
                        class="px-4 py-3 rounded-xl hover:bg-blue-500/10"
                    >
                        Goals
                    </a>

                    <a
                        href="contact.html"
                        class="px-4 py-3 rounded-xl hover:bg-blue-500/10"
                    >
                        Contact
                    </a>

                    @auth
                        <div class="pt-2">
                            <a
                                href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                                class="block text-center py-3 rounded-xl bg-blue-600 font-semibold text-white"
                            >
                                Go to Dashboard &rarr;
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-2 pt-2">
                            <a
                                href="login.html"
                                class="text-center
                                       py-3
                                       rounded-xl
                                       border
                                       border-slate-700"
                            >
                                Login
                            </a>

                            <a
                                href="register.html"
                                class="text-center
                                       py-3
                                       rounded-xl
                                       bg-blue-600"
                            >
                                Register
                            </a>
                        </div>
                    @endauth

                </div>

            </div>

        </nav>

    </header>


    <!-- =========================================
         HERO
    ========================================= -->

    <main>

        <section
            class="relative
                   min-h-screen
                   pt-32
                   pb-20
                   px-5
                   sm:px-8
                   flex
                   items-center"
        >

            <div
                class="max-w-7xl
                       w-full
                       mx-auto
                       grid
                       lg:grid-cols-2
                       gap-12
                       lg:gap-20
                       items-center"
            >

                <!-- Hero Content -->

                <div class="reveal">

                    <div
                        class="inline-flex
                               items-center
                               gap-2
                               px-4
                               py-2
                               rounded-full
                               bg-blue-500/10
                               border
                               border-blue-500/20
                               mb-7"
                    >

                        <span
                            class="w-2
                                   h-2
                                   rounded-full
                                   bg-blue-500
                                   shadow-[0_0_10px_#3B82F6]"
                        ></span>

                        <span
                            class="text-xs
                                   text-blue-400
                                   font-semibold
                                   uppercase
                                   tracking-[.18em]"
                        >
                            AI-Powered Student Finance
                        </span>

                    </div>


                    <h1
                        class="hero-title
                               text-5xl
                               sm:text-6xl
                               lg:text-7xl
                               font-bold
                               leading-[1.04]
                               tracking-tight"
                    >

                        Take Control of

                        <span class="gradient-text">
                            Your Student Finances
                        </span>

                    </h1>


                    <p
                        class="text-slate-400
                               text-lg
                               sm:text-xl
                               leading-8
                               max-w-xl
                               mt-7"
                    >
                        Track spending, manage budgets, achieve savings goals
                        and receive intelligent financial guidance — all in
                        one simple student finance platform.
                    </p>


                    <div
                        class="flex
                               flex-wrap
                               gap-4
                               mt-9"
                    >

                        <a
                            href="#features"
                            class="primary-button
                                   rounded-xl
                                   px-7
                                   py-4
                                   text-white
                                   font-semibold"
                        >

                            <span class="relative z-10">
                                Get Started
                                <span class="ml-2">→</span>
                            </span>

                        </a>


                        <a
                            href="#features"
                            class="secondary-button
                                   rounded-xl
                                   px-7
                                   py-4
                                   text-slate-200
                                   font-semibold"
                        >
                            Learn More
                        </a>

                    </div>


                    <div
                        class="flex
                               flex-wrap
                               gap-5
                               mt-8
                               text-sm
                               text-slate-500"
                    >

                        <span>
                            ✓ Built for students
                        </span>

                        <span>
                            ✓ Smart insights
                        </span>

                        <span>
                            ✓ AI guidance
                        </span>

                    </div>

                </div>


                <!-- Robot Area -->

                <div
                    class="hero-robot-area
                           relative
                           flex
                           items-center
                           justify-center
                           reveal"
                >

                    <div class="hero-glow"></div>


                    <!-- Decorative circles -->

                    <div
                        class="absolute
                               w-[390px]
                               h-[390px]
                               rounded-full
                               border
                               border-blue-500/10"
                    ></div>

                    <div
                        class="absolute
                               w-[300px]
                               h-[300px]
                               rounded-full
                               border
                               border-blue-500/10"
                    ></div>


                    <!-- Robot -->

                    <div
                        id="heroRobot"
                        class="robot-wrapper relative z-20"
                    >

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
                                    $
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Floating Balance -->

                    <div
                        class="floating-card
                               rounded-xl
                               p-4
                               top-10
                               left-0
                               sm:left-2"
                    >

                        <div
                            class="text-[10px]
                                   uppercase
                                   tracking-wider
                                   text-slate-500"
                        >
                            Balance
                        </div>

                        <div
                            class="text-lg
                                   font-bold
                                   text-blue-400
                                   mt-1"
                        >
                            $2,480.50
                        </div>

                    </div>


                    <!-- Floating Budget -->

                    <div
                        class="floating-card
                               rounded-xl
                               p-4
                               top-28
                               right-0"
                    >

                        <div
                            class="text-[10px]
                                   uppercase
                                   tracking-wider
                                   text-slate-500"
                        >
                            Budget
                        </div>

                        <div
                            class="text-lg
                                   font-bold
                                   text-emerald-400
                                   mt-1"
                        >
                            72%
                        </div>

                    </div>


                    <!-- Floating Savings -->

                    <div
                        class="floating-card
                               rounded-xl
                               p-4
                               bottom-20
                               left-0"
                    >

                        <div
                            class="text-[10px]
                                   uppercase
                                   tracking-wider
                                   text-slate-500"
                        >
                            Savings
                        </div>

                        <div
                            class="text-lg
                                   font-bold
                                   text-blue-400
                                   mt-1"
                        >
                            +$420
                        </div>

                    </div>


                    <!-- Floating AI -->

                    <div
                        class="floating-card
                               rounded-xl
                               p-4
                               bottom-10
                               right-0"
                    >

                        <div
                            class="flex
                                   items-center
                                   gap-2"
                        >

                            <span
                                class="w-2
                                       h-2
                                       rounded-full
                                       bg-blue-500
                                       shadow-[0_0_10px_#3B82F6]"
                            ></span>

                            <div>

                                <div
                                    class="text-[10px]
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >
                                    AI Advice
                                </div>

                                <div
                                    class="text-xs
                                           font-semibold
                                           text-slate-200
                                           mt-1"
                                >
                                    Save 10% on food
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================================
             STATS
        ========================================= -->

        <section
            class="px-5
                   sm:px-8
                   pb-24"
        >

            <div
                class="max-w-7xl
                       mx-auto
                       grid
                       grid-cols-2
                       lg:grid-cols-4
                       gap-4"
            >

                <div
                    class="stat-card
                           rounded-2xl
                           p-6
                           text-center
                           reveal"
                >

                    <div
                        class="counter
                               text-3xl
                               sm:text-4xl
                               font-bold
                               text-blue-400"
                        data-target="5000"
                        data-suffix="+"
                    >
                        0
                    </div>

                    <div
                        class="text-sm
                               text-slate-500
                               mt-2"
                    >
                        Students
                    </div>

                </div>


                <div
                    class="stat-card
                           rounded-2xl
                           p-6
                           text-center
                           reveal"
                >

                    <div
                        class="counter
                               text-3xl
                               sm:text-4xl
                               font-bold
                               text-blue-400"
                        data-target="1"
                        data-suffix="M+"
                    >
                        0
                    </div>

                    <div
                        class="text-sm
                               text-slate-500
                               mt-2"
                    >
                        Transactions
                    </div>

                </div>


                <div
                    class="stat-card
                           rounded-2xl
                           p-6
                           text-center
                           reveal"
                >

                    <div
                        class="counter
                               text-3xl
                               sm:text-4xl
                               font-bold
                               text-blue-400"
                        data-target="95"
                        data-suffix="%"
                    >
                        0
                    </div>

                    <div
                        class="text-sm
                               text-slate-500
                               mt-2"
                    >
                        Success Rate
                    </div>

                </div>


                <div
                    class="stat-card
                           rounded-2xl
                           p-6
                           text-center
                           reveal"
                >

                    <div
                        class="counter
                               text-3xl
                               sm:text-4xl
                               font-bold
                               text-blue-400"
                        data-target="250"
                        data-suffix="K+"
                    >
                        0
                    </div>

                    <div
                        class="text-sm
                               text-slate-500
                               mt-2"
                    >
                        Saved
                    </div>

                </div>

            </div>

        </section>


        <!-- =========================================
             FEATURES
        ========================================= -->

        <section
            id="features"
            class="py-24
                   px-5
                   sm:px-8"
        >

            <div class="max-w-7xl mx-auto">

                <div
                    class="max-w-2xl
                           mx-auto
                           text-center
                           reveal"
                >

                    <div
                        class="text-blue-400
                               text-xs
                               font-semibold
                               uppercase
                               tracking-[.25em]"
                    >
                        Everything you need
                    </div>

                    <h2
                        class="text-4xl
                               sm:text-5xl
                               font-bold
                               mt-4"
                    >
                        Your Finances,
                        <span class="gradient-text">
                            Simplified.
                        </span>
                    </h2>

                    <p
                        class="text-slate-400
                               mt-5
                               leading-7"
                    >
                        Powerful tools designed around the way students
                        actually manage money.
                    </p>

                </div>


                <div
                    class="grid
                           sm:grid-cols-2
                           lg:grid-cols-4
                           gap-5
                           mt-14"
                >

                    <!-- Feature 1 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ↗
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            Smart Expense Tracking
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            Understand exactly where your money goes
                            with clear spending activity.
                        </p>

                    </div>


                    <!-- Feature 2 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ◫
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            Budget Planning
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            Create practical budgets that fit your
                            student lifestyle.
                        </p>

                    </div>


                    <!-- Feature 3 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ◎
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            Goal Saving
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            Turn laptops, trips and emergency funds
                            into achievable goals.
                        </p>

                    </div>


                    <!-- Feature 4 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ◇
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            Financial Health
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            See your financial habits through a
                            simple health score.
                        </p>

                    </div>


                    <!-- Feature 5 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ✦
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            AI Coach
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            Receive intelligent financial guidance
                            whenever you need it.
                        </p>

                    </div>


                    <!-- Feature 6 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ▥
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            Smart Reports
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            Turn your financial activity into
                            useful visual reports.
                        </p>

                    </div>


                    <!-- Feature 7 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ★
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            Achievements
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            Stay motivated as you build better
                            financial habits.
                        </p>

                    </div>


                    <!-- Feature 8 -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div class="icon-box">
                            ◌
                        </div>

                        <h3
                            class="font-semibold
                                   text-lg
                                   mt-5"
                        >
                            Financial Insights
                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   leading-6
                                   mt-3"
                        >
                            Discover useful patterns hidden in
                            your financial activity.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================================
             AI COACH PREVIEW
        ========================================= -->

        <section
            class="py-24
                   px-5
                   sm:px-8"
        >

            <div
                class="max-w-7xl
                       mx-auto
                       grid
                       lg:grid-cols-2
                       gap-12
                       items-center"
            >

                <div class="reveal">

                    <div
                        class="text-blue-400
                               text-xs
                               uppercase
                               tracking-[.25em]"
                    >
                        Your intelligent companion
                    </div>

                    <h2
                        class="text-4xl
                               sm:text-5xl
                               font-bold
                               leading-tight
                               mt-4"
                    >
                        Meet Your
                        <span class="gradient-text">
                            AI Coach.
                        </span>
                    </h2>

                    <p
                        class="text-slate-400
                               leading-7
                               mt-6
                               max-w-lg"
                    >
                        Get simple, personalized financial guidance
                        based on your spending patterns and savings goals.
                    </p>

                    <div class="space-y-4 mt-8">

                        <div class="flex gap-3">
                            <span class="text-blue-400">✓</span>
                            <span class="text-slate-300">
                                Personalized spending suggestions
                            </span>
                        </div>

                        <div class="flex gap-3">
                            <span class="text-blue-400">✓</span>
                            <span class="text-slate-300">
                                Goal-based recommendations
                            </span>
                        </div>

                        <div class="flex gap-3">
                            <span class="text-blue-400">✓</span>
                            <span class="text-slate-300">
                                Easy-to-understand financial insights
                            </span>
                        </div>

                    </div>

                </div>


                <!-- Chat Preview -->

                <div
                    class="feature-card
                           rounded-3xl
                           p-5
                           reveal"
                >

                    <div
                        class="flex
                               items-center
                               justify-between
                               pb-4
                               border-b
                               border-slate-700/40"
                    >

                        <div
                            class="flex
                                   items-center
                                   gap-3"
                        >

                            <div
                                class="w-11
                                       h-11
                                       rounded-xl
                                       bg-blue-500/10
                                       border
                                       border-blue-500/20
                                       flex
                                       items-center
                                       justify-center
                                       text-blue-400"
                            >
                                $
                            </div>

                            <div>

                                <div class="font-semibold">
                                    Campus AI Coach
                                </div>

                                <div
                                    class="text-xs
                                           text-emerald-400
                                           mt-1"
                                >
                                    ● Online
                                </div>

                            </div>

                        </div>

                        <div
                            class="text-xs
                                   text-slate-600"
                        >
                            AI Assistant
                        </div>

                    </div>


                    <div class="py-7 space-y-5">

                        <div class="flex justify-end">

                            <div
                                class="max-w-[78%]
                                       rounded-2xl
                                       rounded-br-sm
                                       bg-blue-500/10
                                       border
                                       border-blue-500/15
                                       p-4"
                            >

                                <div
                                    class="text-[10px]
                                           text-blue-400
                                           mb-1"
                                >
                                    Student
                                </div>

                                <p class="text-sm">
                                    How can I save more money?
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-3">

                            <div
                                class="w-9
                                       h-9
                                       rounded-xl
                                       bg-blue-500/10
                                       flex
                                       items-center
                                       justify-center
                                       text-blue-400
                                       flex-shrink-0"
                            >
                                $
                            </div>

                            <div
                                class="max-w-[80%]
                                       rounded-2xl
                                       rounded-bl-sm
                                       bg-[#0A0F1E]
                                       border
                                       border-slate-700/50
                                       p-4"
                            >

                                <div
                                    class="text-[10px]
                                           text-blue-400
                                           mb-1"
                                >
                                    Campus AI
                                </div>

                                <p
                                    id="aiMessage"
                                    class="text-sm
                                           text-slate-300
                                           leading-6"
                                ></p>

                            </div>

                        </div>


                        <div
                            class="rounded-xl
                                   bg-blue-500/5
                                   border
                                   border-blue-500/10
                                   p-4"
                        >

                            <div
                                class="flex
                                       justify-between
                                       text-xs"
                            >

                                <span class="text-slate-500">
                                    Potential monthly savings
                                </span>

                                <span class="text-blue-400">
                                    $84
                                </span>

                            </div>

                            <div
                                class="h-2
                                       bg-slate-800
                                       rounded-full
                                       overflow-hidden
                                       mt-3"
                            >

                                <div
                                    class="h-full
                                           w-[72%]
                                           rounded-full
                                           bg-blue-500
                                           shadow-[0_0_15px_rgba(59,130,246,.35)]"
                                ></div>

                            </div>

                        </div>

                    </div>

                    <div
                        class="flex
                               gap-2"
                    >

                        <div
                            class="flex-1
                                   rounded-xl
                                   bg-[#0A0F1E]
                                   border
                                   border-slate-700/50
                                   px-4
                                   py-3
                                   text-sm
                                   text-slate-600"
                        >
                            Ask your AI Coach...
                        </div>

                        <button
                            class="w-12
                                   rounded-xl
                                   bg-blue-600
                                   hover:bg-blue-500
                                   transition"
                        >
                            →
                        </button>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================================
             GOALS PREVIEW
        ========================================= -->

        <section
            class="py-24
                   px-5
                   sm:px-8"
        >

            <div class="max-w-7xl mx-auto">

                <div
                    class="text-center
                           max-w-2xl
                           mx-auto
                           reveal"
                >

                    <div
                        class="text-blue-400
                               text-xs
                               uppercase
                               tracking-[.25em]"
                    >
                        Plan your future
                    </div>

                    <h2
                        class="text-4xl
                               sm:text-5xl
                               font-bold
                               mt-4"
                    >
                        Make Your Goals
                        <span class="gradient-text">
                            Happen.
                        </span>
                    </h2>

                    <p
                        class="text-slate-400
                               mt-5
                               leading-7"
                    >
                        Whether it is a new laptop or your emergency fund,
                        Campus Coin keeps your progress visible.
                    </p>

                </div>


                <div
                    class="grid
                           sm:grid-cols-2
                           lg:grid-cols-4
                           gap-5
                           mt-14"
                >

                    <!-- Goal -->

                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div
                            class="flex
                                   items-center
                                   justify-between"
                        >

                            <span class="text-3xl">
                                💻
                            </span>

                            <span
                                class="text-xs
                                       text-blue-400"
                            >
                                68%
                            </span>

                        </div>

                        <h3
                            class="font-semibold
                                   mt-5"
                        >
                            Laptop
                        </h3>

                        <div
                            class="flex
                                   justify-between
                                   text-xs
                                   text-slate-500
                                   mt-2"
                        >
                            <span>$1,020 saved</span>
                            <span>$1,500</span>
                        </div>

                        <div
                            class="h-2
                                   bg-slate-800
                                   rounded-full
                                   overflow-hidden
                                   mt-4"
                        >

                            <div
                                class="h-full
                                       w-[68%]
                                       bg-blue-500
                                       rounded-full"
                            ></div>

                        </div>

                    </div>


                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div
                            class="flex
                                   items-center
                                   justify-between"
                        >

                            <span class="text-3xl">
                                📱
                            </span>

                            <span
                                class="text-xs
                                       text-blue-400"
                            >
                                82%
                            </span>

                        </div>

                        <h3
                            class="font-semibold
                                   mt-5"
                        >
                            Phone
                        </h3>

                        <div
                            class="flex
                                   justify-between
                                   text-xs
                                   text-slate-500
                                   mt-2"
                        >
                            <span>$820 saved</span>
                            <span>$1,000</span>
                        </div>

                        <div
                            class="h-2
                                   bg-slate-800
                                   rounded-full
                                   overflow-hidden
                                   mt-4"
                        >

                            <div
                                class="h-full
                                       w-[82%]
                                       bg-blue-500
                                       rounded-full"
                            ></div>

                        </div>

                    </div>


                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div
                            class="flex
                                   items-center
                                   justify-between"
                        >

                            <span class="text-3xl">
                                ✈️
                            </span>

                            <span
                                class="text-xs
                                       text-blue-400"
                            >
                                44%
                            </span>

                        </div>

                        <h3
                            class="font-semibold
                                   mt-5"
                        >
                            Vacation
                        </h3>

                        <div
                            class="flex
                                   justify-between
                                   text-xs
                                   text-slate-500
                                   mt-2"
                        >
                            <span>$660 saved</span>
                            <span>$1,500</span>
                        </div>

                        <div
                            class="h-2
                                   bg-slate-800
                                   rounded-full
                                   overflow-hidden
                                   mt-4"
                        >

                            <div
                                class="h-full
                                       w-[44%]
                                       bg-blue-500
                                       rounded-full"
                            ></div>

                        </div>

                    </div>


                    <div
                        class="feature-card
                               rounded-2xl
                               p-6
                               reveal"
                    >

                        <div
                            class="flex
                                   items-center
                                   justify-between"
                        >

                            <span class="text-3xl">
                                🛡️
                            </span>

                            <span
                                class="text-xs
                                       text-blue-400"
                            >
                                76%
                            </span>

                        </div>

                        <h3
                            class="font-semibold
                                   mt-5"
                        >
                            Emergency Fund
                        </h3>

                        <div
                            class="flex
                                   justify-between
                                   text-xs
                                   text-slate-500
                                   mt-2"
                        >
                            <span>$1,520 saved</span>
                            <span>$2,000</span>
                        </div>

                        <div
                            class="h-2
                                   bg-slate-800
                                   rounded-full
                                   overflow-hidden
                                   mt-4"
                        >

                            <div
                                class="h-full
                                       w-[76%]
                                       bg-blue-500
                                       rounded-full"
                            ></div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================================
             FINAL CTA
        ========================================= -->

        <section
            class="py-28
                   px-5
                   sm:px-8"
        >

            <div
                class="max-w-6xl
                       mx-auto
                       relative
                       overflow-hidden
                       rounded-[30px]
                       border
                       border-blue-500/15
                       bg-[#1B2A41]/60
                       p-10
                       sm:p-16
                       text-center
                       reveal"
            >

                <div
                    class="absolute
                           w-96
                           h-96
                           bg-blue-500/10
                           rounded-full
                           blur-[100px]
                           left-1/2
                           top-1/2
                           -translate-x-1/2
                           -translate-y-1/2"
                ></div>


                <div class="relative z-10">

                    <div
                        class="flex
                               justify-center
                               mb-6"
                    >

                        <div
                            class="robot-wrapper
                                   scale-[.45]"
                        >

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
                                        $
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <h2
                        class="text-4xl
                               sm:text-6xl
                               font-bold
                               leading-tight"
                    >
                        Start Building Better
                        <span class="gradient-text">
                            Financial Habits Today
                        </span>
                    </h2>


                    <p
                        class="text-slate-400
                               max-w-xl
                               mx-auto
                               mt-6
                               leading-7"
                    >
                        Take control of your spending, build smarter habits
                        and work toward the goals that matter to you.
                    </p>


                    <div
                        class="flex
                               justify-center
                               flex-wrap
                               gap-4
                               mt-9"
                    >

                        <a
                            href="register.html"
                            class="primary-button
                                   rounded-xl
                                   px-8
                                   py-4
                                   font-semibold
                                   text-white"
                        >
                            <span class="relative z-10">
                                Get Started →
                            </span>
                        </a>

                        <a
                            href="features.html"
                            class="secondary-button
                                   rounded-xl
                                   px-8
                                   py-4
                                   font-semibold"
                        >
                            Learn More
                        </a>

                    </div>

                </div>

            </div>

        <!-- =========================================
             SITEMAP SECTION (Requirement 64)
        ========================================= -->
        <section id="sitemap" class="py-20 border-t border-slate-800/80 bg-slate-950/60">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        🗺️ Navigation Architecture
                    </span>
                    <h2 class="text-3xl font-extrabold text-white mt-3">Platform Sitemap & Directory</h2>
                    <p class="text-sm text-slate-400 mt-2">Comprehensive architectural navigation map of all public portals, student modules, AI engines, and administrative controls.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Column 1: Public & Informational -->
                    <div class="p-6 rounded-2xl bg-[#1B2A41]/60 border border-slate-800">
                        <div class="flex items-center gap-2 text-blue-400 font-bold text-sm uppercase tracking-wider mb-4">
                            <span>🌐</span>
                            <span>Public Portals</span>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Home Page</a></li>
                            <li><a href="{{ route('features') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Features & Benefits</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> About Campus Coin</a></li>
                            <li><a href="{{ route('faq') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Student FAQ</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Contact Support</a></li>
                        </ul>
                    </div>

                    <!-- Column 2: Authentication & Security -->
                    <div class="p-6 rounded-2xl bg-[#1B2A41]/60 border border-slate-800">
                        <div class="flex items-center gap-2 text-emerald-400 font-bold text-sm uppercase tracking-wider mb-4">
                            <span>🔐</span>
                            <span>Auth & Security</span>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Student Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Student Registration</a></li>
                            <li><a href="{{ route('password.request') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Password Recovery (OTP)</a></li>
                            <li><a href="{{ route('admin.login') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Direct Admin Login</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Student Financial Workspace -->
                    <div class="p-6 rounded-2xl bg-[#1B2A41]/60 border border-slate-800">
                        <div class="flex items-center gap-2 text-amber-400 font-bold text-sm uppercase tracking-wider mb-4">
                            <span>💼</span>
                            <span>Student Financial Hub</span>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Student Dashboard</a></li>
                            <li><a href="{{ route('transactions.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Transactions & CSV Import</a></li>
                            <li><a href="{{ route('budgets.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Budget Goals & Limits</a></li>
                            <li><a href="{{ route('reports.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Monthly Reports & PDF</a></li>
                            <li><a href="{{ route('goals.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Savings Goals Tracker</a></li>
                            <li><a href="{{ route('categories.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Own Categories Manager</a></li>
                            <li><a href="{{ route('profile.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> Profile & Settings</a></li>
                        </ul>
                    </div>

                    <!-- Column 4: Intelligence & Administration -->
                    <div class="p-6 rounded-2xl bg-[#1B2A41]/60 border border-slate-800">
                        <div class="flex items-center gap-2 text-purple-400 font-bold text-sm uppercase tracking-wider mb-4">
                            <span>🤖</span>
                            <span>AI & Admin Systems</span>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li><a href="{{ route('insights.index') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> AI Monthly Insights & Tips</a></li>
                            <li><a href="{{ route('ai.coach') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> AI Financial Coach (Chatbot)</a></li>
                            <li><a href="{{ route('api.ai.suggest') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><span>•</span> AI Auto-Categorizer API</a></li>
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-400 transition-colors flex items-center gap-2"><span>•</span> Admin Control Panel</a></li>
                            <li><a href="{{ route('admin.analytics.index') }}" class="hover:text-amber-400 transition-colors flex items-center gap-2"><span>•</span> Platform Analytics Console</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </main>


    <!-- =========================================
         FOOTER
    ========================================= -->

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

        <!-- Copyright & Sitemap Link (Requirement 64) -->
        <div class="text-center">
            <p class="text-sm text-slate-400">
                © 2026 Campus Coin. All rights reserved.
            </p>
            <div class="mt-2 flex items-center justify-center gap-4 text-xs text-slate-400">
                <a href="#sitemap" class="text-blue-400 hover:underline flex items-center gap-1">
                    <span>🗺️</span>
                    <span>View Interactive Sitemap</span>
                </a>
            </div>
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

    <!-- =========================================
         JAVASCRIPT
    ========================================= -->

    <script>

        /* -----------------------------------------
           MOBILE MENU
        ----------------------------------------- */

        const mobileButton =
            document.getElementById("mobileMenuButton");

        const mobileMenu =
            document.getElementById("mobileMenu");

        mobileButton.addEventListener("click", function () {

            mobileMenu.classList.toggle("hidden");

        });


        /* -----------------------------------------
           SCROLL REVEAL
        ----------------------------------------- */

        const revealObserver =
            new IntersectionObserver(
                function (entries) {

                    entries.forEach(function (entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add("active");

                        }

                    });

                },
                {
                    threshold: .12
                }
            );


        document
            .querySelectorAll(".reveal")
            .forEach(function (element) {

                revealObserver.observe(element);

            });


        /* -----------------------------------------
           COUNTERS
        ----------------------------------------- */

        const counters =
            document.querySelectorAll(".counter");


        const counterObserver =
            new IntersectionObserver(
                function (entries) {

                    entries.forEach(function (entry) {

                        if (
                            !entry.isIntersecting ||
                            entry.target.dataset.started
                        ) {
                            return;
                        }

                        const counter =
                            entry.target;

                        counter.dataset.started =
                            "true";

                        const target =
                            Number(
                                counter.dataset.target
                            );

                        const suffix =
                            counter.dataset.suffix || "";

                        const duration =
                            1800;

                        const start =
                            performance.now();


                        function animateCounter(time) {

                            const progress =
                                Math.min(
                                    (time - start) /
                                    duration,
                                    1
                                );


                            const eased =
                                1 -
                                Math.pow(
                                    1 - progress,
                                    3
                                );


                            const value =
                                Math.floor(
                                    target * eased
                                );


                            counter.textContent =
                                value.toLocaleString() +
                                suffix;


                            if (progress < 1) {

                                requestAnimationFrame(
                                    animateCounter
                                );

                            }

                        }


                        requestAnimationFrame(
                            animateCounter
                        );

                    });

                },
                {
                    threshold: .5
                }
            );


        counters.forEach(function (counter) {

            counterObserver.observe(counter);

        });


        /* -----------------------------------------
           ROBOT EYE TRACKING
        ----------------------------------------- */

        const pupils =
            document.querySelectorAll(".eye-pupil");


        document.addEventListener(
            "mousemove",
            function (event) {

                pupils.forEach(function (pupil) {

                    const eye =
                        pupil.parentElement;

                    const rect =
                        eye.getBoundingClientRect();


                    const centerX =
                        rect.left +
                        rect.width / 2;

                    const centerY =
                        rect.top +
                        rect.height / 2;


                    const deltaX =
                        event.clientX -
                        centerX;

                    const deltaY =
                        event.clientY -
                        centerY;


                    const angle =
                        Math.atan2(
                            deltaY,
                            deltaX
                        );


                    const distance =
                        Math.min(
                            10,
                            Math.hypot(
                                deltaX,
                                deltaY
                            ) / 7
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


        /* -----------------------------------------
           AI TYPING ANIMATION
        ----------------------------------------- */

        const aiMessage =
            document.getElementById("aiMessage");


        const aiText =
            "You spent more on food this month. Reducing food spending by 10% could improve your savings.";


        let aiIndex = 0;


        function typeAI() {

            if (aiIndex < aiText.length) {

                aiMessage.textContent +=
                    aiText.charAt(aiIndex);

                aiIndex++;

                setTimeout(
                    typeAI,
                    25
                );

            }

        }


        const aiObserver =
            new IntersectionObserver(
                function (entries) {

                    if (
                        entries[0].isIntersecting
                    ) {

                        typeAI();

                        aiObserver.disconnect();

                    }

                },
                {
                    threshold: .5
                }
            );


        aiObserver.observe(aiMessage);


        /* -----------------------------------------
           ROBOT MOUSE INTERACTION
        ----------------------------------------- */

        const heroRobot =
            document.getElementById("heroRobot");


        document.addEventListener(
            "mousemove",
            function (event) {

                if (
                    window.innerWidth < 768
                ) {
                    return;
                }


                const x =
                    (
                        window.innerWidth / 2 -
                        event.clientX
                    ) / 100;


                const y =
                    (
                        window.innerHeight / 2 -
                        event.clientY
                    ) / 120;


                heroRobot.style.transform =
                    `translateY(-11px) rotateY(${x}deg) rotateX(${y}deg)`;

            }
        );


        /* -----------------------------------------
           NAVBAR SCROLL EFFECT
        ----------------------------------------- */

        const navbar =
            document.querySelector(".navbar");


        window.addEventListener(
            "scroll",
            function () {

                if (window.scrollY > 30) {

                    navbar.style.boxShadow =
                        "0 20px 60px rgba(0,0,0,.35), 0 0 25px rgba(59,130,246,.05)";

                } else {

                    navbar.style.boxShadow =
                        "0 20px 50px rgba(0,0,0,.18)";

                }

            }
        );


        /* -----------------------------------------
           RANDOM BACKGROUND PARTICLES
        ----------------------------------------- */

        const particleCount = 20;


        for (
            let i = 0;
            i < particleCount;
            i++
        ) {

            const particle =
                document.createElement("div");


            particle.className =
                "particle";


            particle.style.left =
                Math.random() * 100 + "%";


            particle.style.top =
                Math.random() * 100 + "%";


            particle.style.opacity =
                (
                    Math.random() * .45 +
                    .15
                ).toFixed(2);


            particle.style.animationDuration =
                (
                    5 +
                    Math.random() * 8
                ) + "s";


            particle.style.animationDelay =
                (
                    Math.random() * 5
                ) + "s";


            document.body.appendChild(
                particle
            );

        }

    </script>

    @auth
    <!-- Hidden Auto-Logout Form for Session Expiry (Requirement 6) -->
    <form id="autoLogoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
        <input type="hidden" name="session_expired" value="1">
    </form>

    <div id="sessionExpiryModal" class="hidden fixed inset-0 z-[9999] bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-[#1B2A41] border border-red-500/40 rounded-2xl max-w-sm w-full p-6 text-center space-y-4 shadow-2xl">
            <div class="w-14 h-14 rounded-full bg-red-500/10 text-red-400 mx-auto flex items-center justify-center text-2xl border border-red-500/20">
                🔒
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Session Expired</h3>
                <p class="text-xs text-slate-300 mt-2">
                    Your session has expired. You are being automatically logged out for your security.
                </p>
            </div>
            <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                <div class="bg-red-500 h-full w-full animate-pulse"></div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const checkUrl = "{{ route('session.check') }}";
            const sessionLifetimeMs = {{ (int) config('session.lifetime', 120) }} * 60 * 1000;
            let lastActivityTime = Date.now();
            let isLoggingOut = false;

            function updateActivity() {
                lastActivityTime = Date.now();
            }

            ['mousedown', 'mousemove', 'keydown', 'scroll', 'touchstart', 'click'].forEach(evt => {
                window.addEventListener(evt, updateActivity, { passive: true });
            });

            async function checkSession() {
                if (isLoggingOut) return;

                // Check client-side inactivity
                const idleTime = Date.now() - lastActivityTime;
                if (idleTime > sessionLifetimeMs) {
                    triggerAutoLogout('inactivity');
                    return;
                }

                // Check server-side session status
                try {
                    const res = await fetch(checkUrl, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        if (data && data.authenticated === false) {
                            triggerAutoLogout('server_expired');
                        }
                    } else if (res.status === 401 || res.status === 419) {
                        triggerAutoLogout('status_' + res.status);
                    }
                } catch (e) {
                    // Ignore network fluctuations
                }
            }

            function triggerAutoLogout(reason) {
                if (isLoggingOut) return;
                isLoggingOut = true;

                const modal = document.getElementById('sessionExpiryModal');
                if (modal) modal.classList.remove('hidden');

                setTimeout(() => {
                    const logoutForm = document.getElementById('autoLogoutForm');
                    if (logoutForm) {
                        logoutForm.submit();
                    } else {
                        window.location.href = "{{ route('login') }}?session_expired=1";
                    }
                }, 1000);
            }

            // Periodic session heartbeat
            setInterval(checkSession, 15000);
        })();
    </script>
    @endauth

    <script src="theme-toggle.js"></script>
</body>

</html>
