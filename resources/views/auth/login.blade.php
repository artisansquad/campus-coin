<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Coin — Login</title>

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
                transform .08s linear,
                opacity .2s ease;
        }

        .robot-wrapper.happy .robot-eye {
            transform: scaleY(.65);
        }

        .robot-wrapper.password-visible .robot-eye {
            height: 5px;
            border-radius: 50%;
            top: 72px;
            background: #0A0F1E;
            box-shadow:
                0 0 12px
                rgba(59, 130, 246, .25);
        }

        .robot-wrapper.password-visible .eye-pupil {
            opacity: 0;
        }

        .robot-wrapper.password-visible .robot-eye.left {
            left: 43px;
        }

        .robot-wrapper.password-visible .robot-eye.right {
            right: 43px;
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

        .glass-card {
            background:
                #1B2A41;

            border:
                1px solid
                rgba(148, 163, 184, .15);

            box-shadow:
                0 35px 90px
                rgba(0, 0, 0, .35),

                inset 0 1px 0
                rgba(255, 255, 255, .025);
        }

        .input-field {
            background:
                #0A0F1E;

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

        .remember-checkbox {
            appearance: none;
            width: 17px;
            height: 17px;
            border-radius: 5px;

            border:
                1px solid
                #64748B;

            background:
                #0A0F1E;

            cursor: pointer;
            position: relative;
            transition: .2s;
        }

        .remember-checkbox:hover {
            border-color: #3B82F6;
        }

        .remember-checkbox:checked {
            background:
                #3B82F6;

            border-color:
                #3B82F6;
        }

        .remember-checkbox:checked::after {
            content: "✓";
            position: absolute;
            color: white;
            font-size: 12px;
            font-weight: bold;
            left: 3px;
            top: -1px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);

            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #64748B;
            background: transparent;
            border: 0;

            cursor: pointer;
            border-radius: 8px;

            transition:
                color .2s,
                background .2s;
        }

        .password-toggle:hover {
            color: #60A5FA;
            background: rgba(59, 130, 246, .08);
        }

        .password-toggle svg {
            width: 19px;
            height: 19px;
            stroke-width: 1.8;
        }

        .eye-icon-off {
            display: none;
        }

        .password-toggle.active .eye-icon {
            display: none;
        }

        .password-toggle.active .eye-icon-off {
            display: block;
        }

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

        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            color:
                #94A3B8;

            font-size: 12px;
        }

        .security-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;

            background:
                #3B82F6;

            box-shadow:
                0 0 8px
                rgba(59, 130, 246, .5);
        }

        @media(max-width: 900px) {
            .robot-section {
                display: none;
            }

            .glass-card {
                max-width: 600px;
            }
        }

        @media(max-width: 500px) {
            main {
                padding:
                    20px !important;
            }

            .glass-card {
                padding:
                    24px !important;
            }
        }
    </style>
</head>

<body>

    <div class="grid-bg"></div>

    <div class="ambient one"></div>
    <div class="ambient two"></div>

    <div class="particle" style="left:8%;top:22%;"></div>
    <div class="particle" style="left:20%;top:75%;"></div>
    <div class="particle" style="left:82%;top:18%;"></div>
    <div class="particle" style="left:92%;top:70%;"></div>
    <div class="particle" style="left:65%;top:8%;"></div>

    <main
        class="min-h-screen
               flex
               items-center
               justify-center
               p-6"
    >

        <div
            class="w-full
                   max-w-6xl
                   grid
                   lg:grid-cols-2
                   gap-12
                   items-center"
        >

            <section
                class="robot-section
                       flex
                       flex-col
                       items-center
                       justify-center
                       text-center"
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

                        <div
                            id="robotMouth"
                            class="robot-mouth"
                        ></div>

                    </div>

                    <div class="robot-body">

                        <div class="robot-chest">

                            <div class="core">
                                $
                            </div>

                        </div>

                    </div>

                </div>

                <div class="mt-8 max-w-md">

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

                        <p
                            class="text-blue-400
                                   text-xs
                                   font-semibold
                                   tracking-[.22em]
                                   uppercase"
                        >
                            CAMPUS COIN
                        </p>

                    </div>

                    <h1
                        class="text-4xl
                               sm:text-5xl
                               font-bold
                               tracking-tight
                               text-E2E8F0
                               mb-5"
                    >
                        Welcome

                        <span
                            class="text-transparent
                                   bg-clip-text
                                   bg-gradient-to-r
                                   from-blue-400
                                   to-blue-500"
                        >
                            back.
                        </span>
                    </h1>

                    <p
                        id="robotMessage"
                        class="text-slate-400
                               leading-relaxed"
                    >
                        Your money. Your goals.
                        Your financial journey.
                    </p>

                </div>

            </section>

            <section
                class="glass-card
                       rounded-[28px]
                       p-7
                       sm:p-10
                       w-full
                       max-w-xl
                       mx-auto"
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

                        Student Finance

                    </div>

                    <h2
                        class="text-3xl
                               font-bold
                               tracking-tight
                               text-white
                               mt-3"
                    >
                        Welcome back
                    </h2>

                    <p
                        class="text-slate-400
                               text-sm
                               mt-2"
                    >
                        Login to continue managing your finances.
                    </p>

                @if(request()->has('session_expired'))
                    <div class="mb-5 p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Your session has expired. Please log in again to continue.</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-5 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm">
                        <ul class="space-y-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('login.post') }}"
                    id="loginForm"
                >
                    @csrf

                    <div>

                        <label
                            for="email"
                            class="text-sm
                                   font-medium
                                   text-slate-300"
                        >
                            Email address
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="input-field
                                   w-full
                                   mt-2
                                   rounded-xl
                                   px-4
                                   py-3"
                        >

                    </div>

                    <div class="mt-5">

                        <label
                            for="password"
                            class="text-sm
                                   font-medium
                                   text-slate-300"
                        >
                            Password
                        </label>

                        <div class="relative">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="input-field
                                       w-full
                                       mt-2
                                       rounded-xl
                                       px-4
                                       py-3
                                       pr-12"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Show password"
                                aria-pressed="false"
                                class="password-toggle"
                            >

                                <svg
                                    class="eye-icon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <svg
                                    class="eye-icon-off"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M3.587 3.587a2 2 0 0 0-2.828 2.828l16.826 16.826a2 2 0 0 0 2.828-2.828z" />
                                    <path d="M9.88 9.88a3 3 0 0 0 4.24 4.24" />
                                    <path d="M6.71 6.71C4.75 8.1 3.18 9.93 2.06 12a10.75 10.75 0 0 0 19.88 0 10.7 10.7 0 0 0-3.02-3.98" />
                                    <path d="M14.12 14.12a3 3 0 0 1-4.24-4.24" />
                                </svg>

                            </button>

                        </div>

                    </div>

                    <div
                        class="flex
                               items-center
                               justify-between
                               gap-4
                               mt-5"
                    >

                        <label
                            class="flex
                                   items-center
                                   gap-2.5
                                   cursor-pointer
                                   select-none"
                        >

                            <input
                                type="checkbox"
                                name="remember"
                                class="remember-checkbox"
                            >

                            <span
                                class="text-sm
                                       text-slate-400"
                            >
                                Remember me
                            </span>

                        </label>

                       

                    </div>

                    <button
                        type="submit"
                        id="loginButton"
                        class="main-button
                               w-full
                               mt-6
                               py-3.5
                               rounded-xl
                               text-white
                               font-semibold"
                    >

                        <span class="relative z-10">
                            Login to Campus Coin →
                        </span>

                    </button>

            
                    

                    <div
                        class="security-badge
                               mt-5"
                    >

                        <span
                            class="security-dot"
                        ></span>

                        256-Bit SSL Encrypted Campus Session

                    </div>

                    <p
                        class="text-center
                               text-sm
                               text-slate-500
                               mt-6"
                    >

                        Don't have an account?

                        <a
                            href="{{ route('register') }}"
                            class="text-blue-400
                                   font-medium
                                   hover:text-blue-300
                                   transition"
                        >
                            Create student account
                        </a>

                    </p>

                    <div class="text-center mt-3 text-xs text-slate-500">
                        <a href="{{ route('home') }}" class="hover:text-slate-300 transition">← Back to Homepage</a>
                        <span class="mx-2">•</span>
                        <a href="{{ route('admin.login') }}" class="text-purple-400 hover:text-purple-300 transition">Administrator Portal</a>
                    </div>

                </form>

            </section>

        </div>

    </main>

    <script>
        const pupils = document.querySelectorAll(".eye-pupil");
        const robot = document.getElementById("robot");
        const robotMessage = document.getElementById("robotMessage");
        const password = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");
        const loginForm = document.getElementById("loginForm");

        document.addEventListener("mousemove", function(event) {
            if (robot.classList.contains("password-visible")) {
                return;
            }

            pupils.forEach(function(pupil) {
                const eye = pupil.parentElement;
                const rect = eye.getBoundingClientRect();

                const eyeCenterX = rect.left + rect.width / 2;
                const eyeCenterY = rect.top + rect.height / 2;

                const deltaX = event.clientX - eyeCenterX;
                const deltaY = event.clientY - eyeCenterY;

                const angle = Math.atan2(deltaY, deltaX);

                const maxDistance = 11;

                const distance = Math.min(
                    maxDistance,
                    Math.hypot(deltaX, deltaY) / 5
                );

                const x = Math.cos(angle) * distance;
                const y = Math.sin(angle) * distance;

                pupil.style.transform =
                    `translate3d(${x}px, ${y}px, 0)`;
            });
        });

        password.addEventListener("focus", function() {
            if (!robot.classList.contains("password-visible")) {
                robotMessage.textContent =
                    "Enter your password and I'll keep watch.";
            }
        });

        password.addEventListener("input", function() {
            if (robot.classList.contains("password-visible")) {
                return;
            }

            if (password.value.length > 0) {
                robot.classList.add("happy");

                robotMessage.textContent =
                    "Looking good. Ready to get you back in.";
            } else {
                robot.classList.remove("happy");

                robotMessage.textContent =
                    "Your money. Your goals. Your financial journey.";
            }
        });

        togglePassword.addEventListener("click", function() {
            const isVisible = password.type === "text";

            if (isVisible) {
                password.type = "password";

                robot.classList.remove("password-visible");

                this.classList.remove("active");
                this.setAttribute("aria-label", "Show password");
                this.setAttribute("aria-pressed", "false");

                if (password.value.length > 0) {
                    robot.classList.add("happy");

                    robotMessage.textContent =
                        "Looking good. Ready to get you back in.";
                } else {
                    robot.classList.remove("happy");

                    robotMessage.textContent =
                        "Your money. Your goals. Your financial journey.";
                }

            } else {
                password.type = "text";

                robot.classList.remove("happy");
                robot.classList.add("password-visible");

                pupils.forEach(function(pupil) {
                    pupil.style.transform =
                        "translate3d(0, 0, 0)";
                });

                this.classList.add("active");
                this.setAttribute("aria-label", "Hide password");
                this.setAttribute("aria-pressed", "true");

                robotMessage.textContent =
                    "Password visible. I'll look away.";
            }
        });

        loginForm.addEventListener("submit", function() {
            robot.classList.remove("password-visible");

            robotMessage.textContent =
                "Logging you into FinTrack...";
        });
    </script>

</body>

</html>