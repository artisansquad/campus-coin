<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Coin — Contact</title>

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
                    circle at 15% 10%,
                    rgba(59, 130, 246, .14),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 85% 80%,
                    rgba(59, 130, 246, .10),
                    transparent 32%
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
        }

        .ambient {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(120px);
            opacity: .12;
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
                0 0 12px rgba(59, 130, 246, .7);
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

        /* =========================
           GLASS
        ========================= */

        .glass-card {
            background:
                rgba(27, 42, 65, .78);

            border:
                1px solid
                rgba(148, 163, 184, .15);

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);

            box-shadow:
                0 35px 90px
                rgba(0, 0, 0, .35),

                inset 0 1px 0
                rgba(255, 255, 255, .025);

            transition:
                transform .3s ease,
                border-color .3s ease,
                box-shadow .3s ease;
        }

        .glass-card:hover {
            border-color:
                rgba(59, 130, 246, .28);

            box-shadow:
                0 35px 90px
                rgba(0, 0, 0, .38),

                0 0 35px
                rgba(59, 130, 246, .06),

                inset 0 1px 0
                rgba(255, 255, 255, .035);
        }

        /* =========================
           ROBOT
        ========================= */

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

        /* =========================
           FORM
        ========================= */

        .input-field {
            background:
                rgba(10, 15, 30, .85);

            border:
                1px solid
                rgba(148, 163, 184, .18);

            color:
                #E2E8F0;

            transition:
                .25s;
        }

        .input-field::placeholder {
            color:
                #64748B;
        }

        .input-field:hover {
            border-color:
                rgba(59, 130, 246, .35);
        }

        .input-field:focus {
            outline: none;

            border-color:
                #3B82F6;

            box-shadow:
                0 0 0 4px
                rgba(59, 130, 246, .10);
        }

        textarea.input-field {
            resize: vertical;
            min-height: 150px;
        }

        /* =========================
           BUTTON
        ========================= */

        .main-button {
            position: relative;
            overflow: hidden;
            transition: .25s;

            background:
                #3B82F6;

            box-shadow:
                0 10px 30px
                rgba(59, 130, 246, .18);
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

            transform:
                skewX(-20deg);

            transition: .6s;
        }

        .main-button:hover::before {
            left: 140%;
        }

        .main-button:hover {
            transform:
                translateY(-2px);

            background:
                #2563EB;

            box-shadow:
                0 15px 35px
                rgba(59, 130, 246, .28);
        }

        .main-button:active {
            transform:
                translateY(0);
        }

        .outline-button {
            border:
                1px solid
                rgba(59, 130, 246, .35);

            color:
                #93C5FD;

            transition: .25s;
        }

        .outline-button:hover {
            background:
                rgba(59, 130, 246, .10);

            border-color:
                rgba(59, 130, 246, .65);

            transform:
                translateY(-2px);
        }

        /* =========================
           CONTACT ICON
        ========================= */

        .contact-icon {
            width: 46px;
            height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 14px;

            color: #60A5FA;

            background:
                rgba(59, 130, 246, .10);

            border:
                1px solid
                rgba(59, 130, 246, .18);

            box-shadow:
                0 0 25px
                rgba(59, 130, 246, .05);
        }

        .contact-icon svg {
            width: 21px;
            height: 21px;
            stroke-width: 1.7;
        }

        /* =========================
           REVEAL
        ========================= */

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

        .delay-1 {
            transition-delay: .12s;
        }

        .delay-2 {
            transition-delay: .22s;
        }

        .delay-3 {
            transition-delay: .32s;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 900px) {
            .robot-section {
                order: -1;
            }

            .robot-wrapper {
                transform: scale(.82);
                margin-bottom: -25px;
            }
        }

        @media(max-width: 600px) {
            .robot-wrapper {
                transform: scale(.68);
                margin-top: -25px;
                margin-bottom: -50px;
            }

            main {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
</head>

<body>

    <!-- Background -->
    <div class="grid-bg"></div>

    <div class="ambient one"></div>
    <div class="ambient two"></div>

    <!-- Floating particles -->
    <div class="particle" style="left:8%;top:22%;"></div>
    <div class="particle" style="left:20%;top:75%;animation-delay:1s;"></div>
    <div class="particle" style="left:82%;top:18%;animation-delay:2s;"></div>
    <div class="particle" style="left:92%;top:70%;animation-delay:3s;"></div>
    <div class="particle" style="left:65%;top:8%;animation-delay:4s;"></div>
    <div class="particle" style="left:48%;top:55%;animation-delay:2.5s;"></div>

    <!-- =========================
         NAVBAR
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
    <main class="relative z-10">

        <!-- =========================
             HERO
        ========================== -->

        <section
            class="max-w-7xl
                   mx-auto
                   px-6
                   pt-12
                   pb-20
                   lg:pt-20
                   lg:pb-28"
        >

            <div
                class="grid
                       lg:grid-cols-2
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
                               border
                               border-blue-400/20
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
                            Campus Coin Support
                        </span>

                    </div>

                    <h1
                        class="text-5xl
                               sm:text-6xl
                               lg:text-7xl
                               font-bold
                               tracking-tight
                               text-white
                               leading-[1.05]"
                    >

                        Let's talk.

                        <span
                            class="block
                                   text-transparent
                                   bg-clip-text
                                   bg-gradient-to-r
                                   from-blue-400
                                   to-blue-500"
                        >
                            We're here to help.
                        </span>

                    </h1>

                    <p
                        class="mt-7
                               max-w-xl
                               text-slate-400
                               text-lg
                               leading-relaxed"
                    >
                        Have a question about Campus Coin, your account,
                        budgeting, or saving goals? Send us a message and
                        our team will help you move forward with confidence.
                    </p>

                    <div
                        class="flex
                               flex-wrap
                               gap-3
                               mt-8"
                    >

                        <a
                            href="#contact"
                            class="main-button
                                   px-6
                                   py-3
                                   rounded-xl
                                   text-white
                                   font-semibold"
                        >
                            <span class="relative z-10">
                                Send a Message →
                            </span>
                        </a>

                        <a
                            href="#contact-options"
                            class="outline-button
                                   px-6
                                   py-3
                                   rounded-xl
                                   font-semibold"
                        >
                            Contact Options
                        </a>

                    </div>

                </div>

                <!-- Robot -->
                <div
                    class="robot-section
                           flex
                           justify-center
                           reveal
                           delay-1"
                >

                    <div
                        id="robot"
                        class="robot-wrapper"
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
                                    ?
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!-- =========================
             CONTACT AREA
        ========================== -->

        <section
            id="contact"
            class="max-w-7xl
                   mx-auto
                   px-6
                   pb-24"
        >

            <div
                class="grid
                       lg:grid-cols-[1.15fr_.85fr]
                       gap-8"
            >

                <!-- Contact Form -->

                <div
                    class="glass-card
                           rounded-[28px]
                           p-7
                           sm:p-10
                           reveal"
                >

                    <div class="mb-8">

                        <div
                            class="flex
                                   items-center
                                   gap-2
                                   text-blue-400
                                   text-xs
                                   font-semibold
                                   tracking-[.22em]
                                   uppercase"
                        >

                            <span
                                class="w-7
                                       h-px
                                       bg-blue-500"
                            ></span>

                            Get In Touch

                        </div>

                        <h2
                            class="text-3xl
                                   font-bold
                                   text-white
                                   mt-3"
                        >
                            Send us a message
                        </h2>

                        <p
                            class="text-slate-400
                                   text-sm
                                   leading-relaxed
                                   mt-2"
                        >
                            Tell us what's on your mind. We'll get back
                            to you as soon as possible.
                        </p>

                    </div>

                    <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div class="grid sm:grid-cols-2 gap-5">

                            <div>

                                <label
                                    for="name"
                                    class="text-sm
                                           font-medium
                                           text-slate-300"
                                >
                                    Name
                                </label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    required
                                    placeholder="Your name"
                                    class="input-field
                                           w-full
                                           mt-2
                                           rounded-xl
                                           px-4
                                           py-3"
                                >

                            </div>

                            <div>

                                <label
                                    for="email"
                                    class="text-sm
                                           font-medium
                                           text-slate-300"
                                >
                                    Email
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    required
                                    placeholder="you@example.com"
                                    class="input-field
                                           w-full
                                           mt-2
                                           rounded-xl
                                           px-4
                                           py-3"
                                >

                            </div>

                        </div>

                        <div class="mt-5">

                            <label
                                for="message"
                                class="text-sm
                                       font-medium
                                       text-slate-300"
                            >
                                Message
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                required
                                placeholder="How can we help?"
                                class="input-field
                                       w-full
                                       mt-2
                                       rounded-xl
                                       px-4
                                       py-3"
                            ></textarea>

                        </div>

                        <button
                            type="submit"
                            class="main-button
                                   w-full
                                   mt-6
                                   py-3.5
                                   rounded-xl
                                   text-white
                                   font-semibold"
                        >
                            <span class="relative z-10">
                                Send Message →
                            </span>
                        </button>

                        @if(session('success'))
                            <div class="mt-4 rounded-xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-center text-sm text-emerald-300">
                                {{ session('success') }}
                            </div>
                        @elseif($errors->any())
                            <div class="mt-4 rounded-xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-center text-sm text-red-300">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                    </form>

                </div>

                <!-- Contact Cards -->

                <div
                    id="contact-options"
                    class="grid
                           gap-4
                           reveal
                           delay-1"
                >

                    <div
                        class="glass-card
                               rounded-[24px]
                               p-6
                               flex
                               gap-4
                               items-start"
                    >

                        <div class="contact-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 8l9 6 9-6"
                                />
                                <rect
                                    width="18"
                                    height="14"
                                    x="3"
                                    y="5"
                                    rx="2"
                                />
                            </svg>

                        </div>

                        <div>

                            <p
                                class="text-xs
                                       uppercase
                                       tracking-[.18em]
                                       text-blue-400
                                       font-semibold"
                            >
                                Email
                            </p>

                            <h3
                                class="text-white
                                       font-semibold
                                       mt-1"
                            >
                                talhaowais585@gmail.com
                            </h3>

                            <p
                                class="text-sm
                                       text-slate-500
                                       mt-1"
                            >
                                Send us your questions anytime.
                            </p>

                        </div>

                    </div>

                    <div
                        class="glass-card
                               rounded-[24px]
                               p-6
                               flex
                               gap-4
                               items-start"
                    >

                        <div class="contact-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.432-7.432 1.125 1.125 0 01.38-1.21l1.293-.97c.363-.272.52-.732.417-1.173L6.724 2.852A1.125 1.125 0 005.633 2H4.25A2.25 2.25 0 002 4.25v2.5z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p
                                class="text-xs
                                       uppercase
                                       tracking-[.18em]
                                       text-blue-400
                                       font-semibold"
                            >
                                Phone
                            </p>

                            <h3
                                class="text-white
                                       font-semibold
                                       mt-1"
                            >
                                +92 308-8385348
                            </h3>

                            <p
                                class="text-sm
                                       text-slate-500
                                       mt-1"
                            >
                                Mon–Fri · 9 AM–6 PM
                            </p>

                        </div>

                    </div>

                    <div
                        class="glass-card
                               rounded-[24px]
                               p-6
                               flex
                               gap-4
                               items-start"
                    >

                        <div class="contact-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9.879 7.519A3 3 0 0112 6.75a3 3 0 012.121.879m-4.242 0L6.75 10.757m8.742-3.238l3.121 3.238M7.5 18h9M8.25 21h7.5M12 3v3.75"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 21a9 9 0 100-18 9 9 0 000 18z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p
                                class="text-xs
                                       uppercase
                                       tracking-[.18em]
                                       text-blue-400
                                       font-semibold"
                            >
                                Support
                            </p>

                            <h3
                                class="text-white
                                       font-semibold
                                       mt-1"
                            >
                                Student Support Center
                            </h3>

                            <p
                                class="text-sm
                                       text-slate-500
                                       mt-1"
                            >
                                Help with accounts, goals, and saving.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!-- =========================
             ROBOT HELP CARD
        ========================== -->

        <section
            class="max-w-5xl
                   mx-auto
                   px-6
                   pb-24"
        >

            <div
                class="glass-card
                       rounded-[30px]
                       p-7
                       sm:p-10
                       overflow-hidden
                       relative
                       reveal"
            >

                <div
                    class="absolute
                           -right-24
                           -top-24
                           w-72
                           h-72
                           rounded-full
                           bg-blue-500/10
                           blur-3xl"
                ></div>

                <div
                    class="relative
                           flex
                           flex-col
                           md:flex-row
                           items-center
                           gap-8"
                >

                    <div
                        class="scale-[.62]
                               -my-16
                               shrink-0"
                    >

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
                                        $
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="text-center md:text-left">

                        <div
                            class="text-blue-400
                                   text-xs
                                   font-semibold
                                   tracking-[.22em]
                                   uppercase"
                        >
                            Meet your Campus Coin helper
                        </div>

                        <h2
                            class="text-3xl
                                   font-bold
                                   text-white
                                   mt-2"
                        >
                            Not sure where to start?
                        </h2>

                        <p
                            class="text-slate-400
                                   leading-relaxed
                                   mt-3
                                   max-w-2xl"
                        >
                            Whether you're setting your first savings goal
                            or trying to understand your budget, we're here
                            to help make student finance feel simpler.
                        </p>

                    </div>

                </div>

            </div>

        </section>

        <!-- =========================
             CTA
        ========================== -->

        <section
            class="max-w-5xl
                   mx-auto
                   px-6
                   pb-28"
        >

            <div
                class="glass-card
                       rounded-[30px]
                       text-center
                       p-9
                       sm:p-14
                       relative
                       overflow-hidden
                       reveal"
            >

                <div
                    class="absolute
                           left-1/2
                           top-1/2
                           -translate-x-1/2
                           -translate-y-1/2
                           w-96
                           h-96
                           rounded-full
                           bg-blue-500/10
                           blur-3xl"
                ></div>

                <div class="relative">

                    <div
                        class="inline-flex
                               items-center
                               gap-2
                               px-3
                               py-1.5
                               rounded-full
                               bg-blue-500/10
                               border
                               border-blue-400/20
                               mb-5"
                    >

                        <span
                            class="w-2
                                   h-2
                                   rounded-full
                                   bg-blue-500"
                        ></span>

                        <span
                            class="text-blue-400
                                   text-xs
                                   font-semibold
                                   tracking-[.18em]
                                   uppercase"
                        >
                            Your financial journey starts here
                        </span>

                    </div>

                    <h2
                        class="text-3xl
                               sm:text-4xl
                               font-bold
                               text-white"
                    >
                        Ready to take control?
                    </h2>

                    <p
                        class="text-slate-400
                               max-w-xl
                               mx-auto
                               mt-4
                               leading-relaxed"
                    >
                        Create your Campus Coin account and start building
                        better financial habits today.
                    </p>

                    <a
                        href="register.html"
                        class="main-button
                               inline-block
                               mt-7
                               px-8
                               py-3.5
                               rounded-xl
                               text-white
                               font-semibold"
                    >
                        <span class="relative z-10">
                            Get Started →
                        </span>
                    </a>

                </div>

            </div>

        </section>

    </main>

    <!-- =========================
         FOOTER
    ========================== -->

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
        /* =========================
           ROBOT EYE TRACKING
        ========================== */

        const pupils =
            document.querySelectorAll(".eye-pupil");

        document.addEventListener("mousemove", function(event) {

            pupils.forEach(function(pupil) {

                const eye =
                    pupil.parentElement;

                const rect =
                    eye.getBoundingClientRect();

                const eyeCenterX =
                    rect.left + rect.width / 2;

                const eyeCenterY =
                    rect.top + rect.height / 2;

                const deltaX =
                    event.clientX - eyeCenterX;

                const deltaY =
                    event.clientY - eyeCenterY;

                const angle =
                    Math.atan2(
                        deltaY,
                        deltaX
                    );

                const maxDistance = 10;

                const distance =
                    Math.min(
                        maxDistance,
                        Math.hypot(
                            deltaX,
                            deltaY
                        ) / 5
                    );

                const x =
                    Math.cos(angle) * distance;

                const y =
                    Math.sin(angle) * distance;

                pupil.style.transform =
                    `translate3d(${x}px, ${y}px, 0)`;
            });

        });


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
                    threshold: .12
                }
            );

        revealElements.forEach(function(element) {
            revealObserver.observe(element);
        });


        /* =========================
           CONTACT FORM
        ========================== */

        const contactForm =
            document.getElementById("contactForm");

        // Form will submit normally to backend - no preventDefault needed
    </script>

    <script src="theme-toggle.js"></script>
</body>

</html>
