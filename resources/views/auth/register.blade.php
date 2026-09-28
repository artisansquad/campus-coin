<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Coin — Create Account</title>

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

        :root {
            --bg: #0A0F1E;
            --card: #1B2A41;
            --primary: #3B82F6;
            --muted: #94A3B8;
            --text: #E2E8F0;
            --border: rgba(148, 163, 184, 0.16);
            --primary-soft: rgba(59, 130, 246, 0.10);
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
            color: var(--text);
            background:
                radial-gradient(
                    circle at 15% 10%,
                    rgba(59, 130, 246, 0.12),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 85% 90%,
                    rgba(59, 130, 246, 0.08),
                    transparent 32%
                ),
                var(--bg);
            overflow-x: hidden;
        }

        .grid-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .16;
            background-image:
                linear-gradient(
                    rgba(148, 163, 184, .045) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(148, 163, 184, .045) 1px,
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
            width: 420px;
            height: 420px;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(110px);
            opacity: .12;
        }

        .ambient.one {
            top: -260px;
            left: -160px;
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
            box-shadow:
                0 0 12px
                rgba(59, 130, 246, .55);
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

        .robot-section {
            min-width: 0;
        }

        .robot-wrapper {
            position: relative;
            width: 250px;
            animation: robotFloat 4s ease-in-out infinite;
        }

        @keyframes robotFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
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
                rgba(59, 130, 246, .15);
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
                    #243b5a,
                    #1B2A41 50%,
                    #111b2e
                );
            border:
                1px solid
                rgba(148, 163, 184, .20);
            box-shadow:
                0 25px 60px
                rgba(0, 0, 0, .30),
                0 0 45px
                rgba(59, 130, 246, .10),
                inset 0 1px 0
                rgba(226, 232, 240, .06);
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
            background: var(--primary);
            box-shadow:
                0 0 15px
                rgba(59, 130, 246, .35);
        }

        .robot-signal {
            position: absolute;
            width: 12px;
            height: 12px;
            left: 50%;
            top: -8px;
            transform:
                translateX(-50%);
            border-radius: 50%;
            background: var(--primary);
            box-shadow:
                0 0 12px
                rgba(59, 130, 246, .7);
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
                opacity: .5;
            }
        }

        .robot-ear {
            position: absolute;
            top: 65px;
            width: 20px;
            height: 52px;
            border-radius: 12px;
            background: #17253b;
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
            background: var(--primary);
            box-shadow:
                0 0 10px
                rgba(59, 130, 246, .8);
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
                rgba(59, 130, 246, .65);
            overflow: hidden;
            box-shadow:
                0 0 20px
                rgba(59, 130, 246, .12);
            transition: .25s;
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
                    #60A5FA 25%,
                    #3B82F6 70%
                );
            box-shadow:
                0 0 12px
                rgba(59, 130, 246, .75);
            transition:
                transform .12s linear,
                opacity .2s;
        }

        .robot-wrapper.password-mode .robot-eye {
            background: transparent;
            border-color: transparent;
            box-shadow: none;
            overflow: visible;
        }

        .robot-wrapper.password-mode .robot-eye::after {
            content: "";
            position: absolute;
            left: 4px;
            right: 4px;
            top: 50%;
            height: 3px;
            border-radius: 50%;
            background: var(--primary);
            box-shadow:
                0 0 8px
                rgba(59, 130, 246, .45);
            transform:
                translateY(-50%)
                rotate(-8deg);
        }

        .robot-wrapper.password-mode .robot-eye.right::after {
            transform:
                translateY(-50%)
                rotate(8deg);
        }

        .robot-wrapper.password-mode .eye-pupil {
            opacity: 0;
        }

        .robot-mouth {
            position: absolute;
            width: 65px;
            height: 20px;
            left: 77px;
            bottom: 29px;
            border-bottom:
                3px solid
                var(--primary);
            border-radius: 50%;
            filter:
                drop-shadow(
                    0 0 5px
                    rgba(59, 130, 246, .4)
                );
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
                    #243b5a,
                    #111d31
                );
            border:
                1px solid
                rgba(148, 163, 184, .18);
            box-shadow:
                0 25px 50px
                rgba(0, 0, 0, .25),
                inset 0 1px 0
                rgba(226, 232, 240, .04);
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
            color: var(--text);
            font-weight: 800;
            background: var(--primary);
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
                linear-gradient(
                    145deg,
                    rgba(27, 42, 65, .96),
                    rgba(18, 31, 51, .96)
                );
            border:
                1px solid
                var(--border);
            backdrop-filter:
                blur(24px);
            -webkit-backdrop-filter:
                blur(24px);
            box-shadow:
                0 35px 90px
                rgba(0, 0, 0, .32),
                inset 0 1px 0
                rgba(226, 232, 240, .035);
        }

        .input-field {
            background:
                rgba(10, 15, 30, .65);
            border:
                1px solid
                rgba(148, 163, 184, .18);
            color:
                var(--text);
            transition:
                .25s;
        }

        .input-field::placeholder {
            color:
                rgba(148, 163, 184, .55);
        }

        .input-field:hover {
            border-color:
                rgba(59, 130, 246, .35);
        }

        .input-field:focus {
            outline: none;
            border-color:
                var(--primary);
            background:
                rgba(10, 15, 30, .85);
            box-shadow:
                0 0 0 4px
                rgba(59, 130, 246, .09);
        }

        select.input-field {
            color:
                var(--text);
            cursor: pointer;
        }

        select.input-field option {
            background:
                var(--card);
            color:
                var(--text);
        }

        .currency-wrapper {
            position: relative;
        }

        .currency-symbol {
            position: absolute;
            left: 16px;
            top: 50%;
            transform:
                translateY(-50%);
            color:
                var(--primary);
            font-size: 14px;
            font-weight: 700;
            pointer-events: none;
        }

        .currency-select {
            padding-left: 40px !important;
        }

        .currency-info {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            color:
                var(--muted);
            font-size: 11px;
        }

        .currency-info strong {
            color:
                var(--text);
        }

        .saving-goal-box {
            background:
                rgba(59, 130, 246, .045);
            border:
                1px solid
                rgba(59, 130, 246, .14);
        }

        .saving-preset {
            border:
                1px solid
                rgba(148, 163, 184, .14);
            background:
                rgba(10, 15, 30, .35);
            color:
                var(--muted);
            transition:
                .2s;
        }

        .saving-preset:hover {
            border-color:
                rgba(59, 130, 246, .40);
            background:
                rgba(59, 130, 246, .08);
            color:
                var(--text);
        }

        .saving-preset.selected {
            border-color:
                rgba(59, 130, 246, .55);
            background:
                rgba(59, 130, 246, .15);
            color:
                #E2E8F0;
            box-shadow:
                0 0 0 2px
                rgba(59, 130, 246, .06);
        }

        .radar {
            width: 100px;
            height: 100px;
            position: relative;
            border-radius: 50%;
            background:
                radial-gradient(
                    circle,
                    rgba(59, 130, 246, .07),
                    rgba(10, 15, 30, .15)
                );
        }

        .radar-circle {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border:
                1px solid
                rgba(59, 130, 246, .18);
        }

        .radar-circle:nth-child(2) {
            inset: 17px;
        }

        .radar-circle:nth-child(3) {
            inset: 34px;
        }

        .radar-line-horizontal {
            position: absolute;
            width: 100%;
            height: 1px;
            top: 50%;
            background:
                rgba(59, 130, 246, .12);
        }

        .radar-line-vertical {
            position: absolute;
            height: 100%;
            width: 1px;
            left: 50%;
            background:
                rgba(59, 130, 246, .12);
        }

        .radar-sweep {
            position: absolute;
            width: 50%;
            height: 50%;
            left: 50%;
            top: 50%;
            transform-origin:
                0 0;
            background:
                linear-gradient(
                    45deg,
                    rgba(59, 130, 246, .20),
                    transparent
                );
            animation:
                radarSweep 2s linear infinite;
            clip-path:
                polygon(
                    0 0,
                    100% 0,
                    0 100%
                );
        }

        @keyframes radarSweep {
            from {
                transform:
                    rotate(0deg);
            }

            to {
                transform:
                    rotate(360deg);
            }
        }

        .strength-bar {
            height: 5px;
            border-radius: 5px;
            background:
                rgba(148, 163, 184, .10);
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 5px;
            background:
                var(--primary);
            transition:
                .4s;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform:
                translateY(-50%);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: #94A3B8;
            background: transparent;
            transition:
                .2s;
        }

        .password-toggle:hover {
            color: #60A5FA;
            background:
                rgba(59, 130, 246, .08);
        }

        .password-toggle:focus-visible {
            outline: none;
            color: #60A5FA;
            box-shadow:
                0 0 0 3px
                rgba(59, 130, 246, .12);
        }

        .password-toggle svg {
            width: 19px;
            height: 19px;
            stroke-width: 1.8;
        }

        .main-button {
            position: relative;
            overflow: hidden;
            transition:
                .25s;
            background:
                var(--primary);
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
                    rgba(226, 232, 240, .14),
                    transparent
                );
            transform:
                skewX(-20deg);
            transition:
                .6s;
        }

        .main-button:hover::before {
            left: 140%;
        }

        .main-button:hover {
            transform:
                translateY(-2px);
            background:
                #4B8DF8;
            box-shadow:
                0 15px 35px
                rgba(59, 130, 246, .26);
        }

        .main-button:active {
            transform:
                translateY(0);
        }

        .main-button:focus-visible {
            outline: none;
            box-shadow:
                0 0 0 4px
                rgba(59, 130, 246, .20);
        }

        .form-scroll {
            min-height: 0;
        }

        @media (min-width: 901px) {
            html,
            body {
                height: 100%;
                overflow: hidden;
            }

            main {
                height: 100vh;
                min-height: 100vh;
                overflow: hidden;
            }

            .page-grid {
                height: 100vh;
                max-height: 100vh;
                align-items: stretch !important;
            }

            .robot-section {
                height: 100vh;
                position: sticky;
                top: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: visible;
            }

            .form-scroll {
                height: 100vh;
                max-height: 100vh;
                overflow-y: auto;
                overflow-x: hidden;
                padding:
                    40px 10px;
                scrollbar-width: thin;
                scrollbar-color:
                    rgba(59, 130, 246, .35)
                    transparent;
            }

            .form-scroll::-webkit-scrollbar {
                width: 6px;
            }

            .form-scroll::-webkit-scrollbar-track {
                background: transparent;
            }

            .form-scroll::-webkit-scrollbar-thumb {
                background:
                    rgba(59, 130, 246, .35);
                border-radius: 10px;
            }

            .form-scroll::-webkit-scrollbar-thumb:hover {
                background:
                    rgba(59, 130, 246, .55);
            }
        }

        @media(max-width: 900px) {
            body {
                overflow-x: hidden;
                overflow-y: auto;
            }

            .robot-section {
                display: none;
            }

            .form-scroll {
                height: auto;
                max-height: none;
                overflow: visible;
                padding: 0;
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

            .radar {
                width: 82px;
                height: 82px;
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
            class="page-grid
                   w-full
                   max-w-6xl
                   grid
                   lg:grid-cols-2
                   gap-12
                   items-start"
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
                                   bg-blue-500
                                   shadow-[0_0_10px_#3B82F6]"
                        ></span>

                        <p
                            class="text-blue-300
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
                               text-[#E2E8F0]
                               mb-5"
                    >
                        Start your

                        <span
                            class="text-transparent
                                   bg-clip-text
                                   bg-gradient-to-r
                                   from-blue-400
                                   to-blue-500"
                        >
                            financial journey.
                        </span>

                    </h1>

                    <p
                        id="robotMessage"
                        class="text-[#94A3B8]
                               leading-relaxed"
                    >
                        Hi! I'm your financial buddy.
                        Let's create your student account.
                    </p>

                </div>

            </section>

            <div class="form-scroll">

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
                                   text-[#E2E8F0]
                                   mt-3"
                        >
                            Create your account
                        </h2>

                        <p
                            class="text-[#94A3B8]
                                   text-sm
                                   mt-2"
                        >
                            Take control of your money from day one.
                        </p>

                    </div>

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
                        action="{{ route('register.post') }}"
                        id="registerForm"
                    >
                        @csrf

                        <div
                            class="grid
                                   sm:grid-cols-2
                                   gap-4"
                        >

                            <div>

                                <label
                                    for="firstName"
                                    class="text-sm
                                           font-medium
                                           text-[#E2E8F0]"
                                >
                                    First name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="firstName"
                                    required
                                    autocomplete="given-name"
                                    placeholder="Alex"
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
                                    for="lastName"
                                    class="text-sm
                                           font-medium
                                           text-[#E2E8F0]"
                                >
                                    Last name
                                </label>

                                <input
                                    type="text"
                                    name="last_name"
                                    id="lastName"
                                    required
                                    autocomplete="family-name"
                                    placeholder="Johnson"
                                    class="input-field
                                           w-full
                                           mt-2
                                           rounded-xl
                                           px-4
                                           py-3"
                                >

                            </div>

                        </div>

                        <div class="mt-4">

                            <label
                                for="email"
                                class="text-sm
                                       font-medium
                                       text-[#E2E8F0]"
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

                        <div
                            class="grid
                                   sm:grid-cols-2
                                   gap-4
                                   mt-4"
                        >

                            <div>

                                <label
                                    for="age"
                                    class="text-sm
                                           font-medium
                                           text-[#E2E8F0]"
                                >
                                    Age
                                </label>

                                <input
                                    type="number"
                                    name="age"
                                    id="age"
                                    min="13"
                                    max="100"
                                    required
                                    placeholder="20"
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
                                    for="education"
                                    class="text-sm
                                           font-medium
                                           text-[#E2E8F0]"
                                >
                                    Education
                                </label>

                                <select
                                    name="education"
                                    id="education"
                                    required
                                    class="input-field
                                           w-full
                                           mt-2
                                           rounded-xl
                                           px-4
                                           py-3"
                                >

                                    <option value="">
                                        Select education
                                    </option>

                                    <option value="high_school">
                                        High School
                                    </option>

                                    <option value="college">
                                        College
                                    </option>

                                    <option value="undergraduate">
                                        Undergraduate
                                    </option>

                                    <option value="graduate">
                                        Graduate
                                    </option>

                                    <option value="other">
                                        Other
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="mt-5">

                            <div
                                class="flex
                                       items-center
                                       justify-between
                                       mb-2"
                            >

                                <label
                                    for="currency"
                                    class="text-sm
                                           font-medium
                                           text-[#E2E8F0]"
                                >
                                    Preferred currency
                                </label>

                                <span
                                    class="text-xs
                                           text-[#94A3B8]"
                                >
                                    Account currency
                                </span>

                            </div>

                            <div class="currency-wrapper">

                                <span
                                    id="currencySymbol"
                                    class="currency-symbol"
                                >
                                    ₨
                                </span>

                                <select
                                    name="currency"
                                    id="currency"
                                    required
                                    class="input-field
                                           currency-select
                                           w-full
                                           rounded-xl
                                           py-3
                                           pr-4"
                                >

                                    <optgroup label="Popular">

                                        <option
                                            value="PKR"
                                            data-symbol="₨"
                                            data-name="Pakistani Rupee"
                                            selected
                                        >
                                            🇵🇰 Pakistan — PKR (₨)
                                        </option>

                                        <option
                                            value="USD"
                                            data-symbol="$"
                                            data-name="US Dollar"
                                        >
                                            🇺🇸 United States — USD ($)
                                        </option>

                                        <option
                                            value="EUR"
                                            data-symbol="€"
                                            data-name="Euro"
                                        >
                                            🇪🇺 European Union — EUR (€)
                                        </option>

                                        <option
                                            value="GBP"
                                            data-symbol="£"
                                            data-name="British Pound"
                                        >
                                            🇬🇧 United Kingdom — GBP (£)
                                        </option>

                                        <option
                                            value="INR"
                                            data-symbol="₹"
                                            data-name="Indian Rupee"
                                        >
                                            🇮🇳 India — INR (₹)
                                        </option>

                                    </optgroup>

                                    <optgroup label="Asia">

                                        <option value="BDT" data-symbol="৳" data-name="Bangladeshi Taka">
                                            🇧🇩 Bangladesh — BDT (৳)
                                        </option>

                                        <option value="CNY" data-symbol="¥" data-name="Chinese Yuan">
                                            🇨🇳 China — CNY (¥)
                                        </option>

                                        <option value="JPY" data-symbol="¥" data-name="Japanese Yen">
                                            🇯🇵 Japan — JPY (¥)
                                        </option>

                                        <option value="KRW" data-symbol="₩" data-name="South Korean Won">
                                            🇰🇷 South Korea — KRW (₩)
                                        </option>

                                        <option value="IDR" data-symbol="Rp" data-name="Indonesian Rupiah">
                                            🇮🇩 Indonesia — IDR (Rp)
                                        </option>

                                        <option value="MYR" data-symbol="RM" data-name="Malaysian Ringgit">
                                            🇲🇾 Malaysia — MYR (RM)
                                        </option>

                                        <option value="SGD" data-symbol="S$" data-name="Singapore Dollar">
                                            🇸🇬 Singapore — SGD (S$)
                                        </option>

                                        <option value="THB" data-symbol="฿" data-name="Thai Baht">
                                            🇹🇭 Thailand — THB (฿)
                                        </option>

                                        <option value="VND" data-symbol="₫" data-name="Vietnamese Dong">
                                            🇻🇳 Vietnam — VND (₫)
                                        </option>

                                        <option value="PHP" data-symbol="₱" data-name="Philippine Peso">
                                            🇵🇭 Philippines — PHP (₱)
                                        </option>

                                        <option value="HKD" data-symbol="HK$" data-name="Hong Kong Dollar">
                                            🇭🇰 Hong Kong — HKD (HK$)
                                        </option>

                                        <option value="TWD" data-symbol="NT$" data-name="New Taiwan Dollar">
                                            🇹🇼 Taiwan — TWD (NT$)
                                        </option>

                                    </optgroup>

                                    <optgroup label="Middle East">

                                        <option value="AED" data-symbol="د.إ" data-name="UAE Dirham">
                                            🇦🇪 United Arab Emirates — AED (د.إ)
                                        </option>

                                        <option value="SAR" data-symbol="﷼" data-name="Saudi Riyal">
                                            🇸🇦 Saudi Arabia — SAR (﷼)
                                        </option>

                                        <option value="QAR" data-symbol="﷼" data-name="Qatari Riyal">
                                            🇶🇦 Qatar — QAR (﷼)
                                        </option>

                                        <option value="KWD" data-symbol="د.ك" data-name="Kuwaiti Dinar">
                                            🇰🇼 Kuwait — KWD (د.ك)
                                        </option>

                                        <option value="BHD" data-symbol=".د.ب" data-name="Bahraini Dinar">
                                            🇧🇭 Bahrain — BHD (.د.ب)
                                        </option>

                                        <option value="OMR" data-symbol="﷼" data-name="Omani Rial">
                                            🇴🇲 Oman — OMR (﷼)
                                        </option>

                                        <option value="JOD" data-symbol="د.ا" data-name="Jordanian Dinar">
                                            🇯🇴 Jordan — JOD (د.ا)
                                        </option>

                                        <option value="ILS" data-symbol="₪" data-name="Israeli New Shekel">
                                            🇮🇱 Israel — ILS (₪)
                                        </option>

                                        <option value="TRY" data-symbol="₺" data-name="Turkish Lira">
                                            🇹🇷 Türkiye — TRY (₺)
                                        </option>

                                    </optgroup>

                                    <optgroup label="Europe">

                                        <option value="CHF" data-symbol="CHF" data-name="Swiss Franc">
                                            🇨🇭 Switzerland — CHF
                                        </option>

                                        <option value="NOK" data-symbol="kr" data-name="Norwegian Krone">
                                            🇳🇴 Norway — NOK (kr)
                                        </option>

                                        <option value="SEK" data-symbol="kr" data-name="Swedish Krona">
                                            🇸🇪 Sweden — SEK (kr)
                                        </option>

                                        <option value="DKK" data-symbol="kr" data-name="Danish Krone">
                                            🇩🇰 Denmark — DKK (kr)
                                        </option>

                                        <option value="PLN" data-symbol="zł" data-name="Polish Zloty">
                                            🇵🇱 Poland — PLN (zł)
                                        </option>

                                        <option value="CZK" data-symbol="Kč" data-name="Czech Koruna">
                                            🇨🇿 Czechia — CZK (Kč)
                                        </option>

                                        <option value="HUF" data-symbol="Ft" data-name="Hungarian Forint">
                                            🇭🇺 Hungary — HUF (Ft)
                                        </option>

                                        <option value="RON" data-symbol="lei" data-name="Romanian Leu">
                                            🇷🇴 Romania — RON (lei)
                                        </option>

                                        <option value="UAH" data-symbol="₴" data-name="Ukrainian Hryvnia">
                                            🇺🇦 Ukraine — UAH (₴)
                                        </option>

                                    </optgroup>

                                    <optgroup label="Americas">

                                        <option value="CAD" data-symbol="C$" data-name="Canadian Dollar">
                                            🇨🇦 Canada — CAD (C$)
                                        </option>

                                        <option value="AUD" data-symbol="A$" data-name="Australian Dollar">
                                            🇦🇺 Australia — AUD (A$)
                                        </option>

                                        <option value="NZD" data-symbol="NZ$" data-name="New Zealand Dollar">
                                            🇳🇿 New Zealand — NZD (NZ$)
                                        </option>

                                        <option value="MXN" data-symbol="MX$" data-name="Mexican Peso">
                                            🇲🇽 Mexico — MXN (MX$)
                                        </option>

                                        <option value="BRL" data-symbol="R$" data-name="Brazilian Real">
                                            🇧🇷 Brazil — BRL (R$)
                                        </option>

                                        <option value="ARS" data-symbol="$" data-name="Argentine Peso">
                                            🇦🇷 Argentina — ARS ($)
                                        </option>

                                        <option value="CLP" data-symbol="$" data-name="Chilean Peso">
                                            🇨🇱 Chile — CLP ($)
                                        </option>

                                    </optgroup>

                                    <optgroup label="Africa">

                                        <option value="ZAR" data-symbol="R" data-name="South African Rand">
                                            🇿🇦 South Africa — ZAR (R)
                                        </option>

                                        <option value="EGP" data-symbol="E£" data-name="Egyptian Pound">
                                            🇪🇬 Egypt — EGP (E£)
                                        </option>

                                        <option value="NGN" data-symbol="₦" data-name="Nigerian Naira">
                                            🇳🇬 Nigeria — NGN (₦)
                                        </option>

                                        <option value="KES" data-symbol="KSh" data-name="Kenyan Shilling">
                                            🇰🇪 Kenya — KES (KSh)
                                        </option>

                                        <option value="GHS" data-symbol="GH₵" data-name="Ghanaian Cedi">
                                            🇬🇭 Ghana — GHS (GH₵)
                                        </option>

                                    </optgroup>

                                </select>

                            </div>

                            <div class="currency-info">

                                <span>Selected:</span>

                                <strong id="currencyName">
                                    Pakistani Rupee
                                </strong>

                                <span>•</span>

                                <strong id="currencyCode">
                                    PKR
                                </strong>

                            </div>

                        </div>

                        <div class="mt-5">
                            <div class="flex items-center justify-between mb-2">
                                <label for="monthlyAllowance" class="text-sm font-medium text-[#E2E8F0]">
                                    Monthly allowance baseline
                                </label>
                                <span class="text-xs text-[#94A3B8]">From parents / work</span>
                            </div>
                            <input
                                type="number"
                                name="monthly_allowance_baseline"
                                id="monthlyAllowance"
                                min="0"
                                step="0.01"
                                placeholder="e.g. 25,000"
                                class="input-field w-full rounded-xl px-4 py-3"
                            >
                        </div>

                        <div class="mt-5">

                            <div
                                class="flex
                                       items-center
                                       justify-between
                                       mb-2"
                            >

                                <label
                                    for="monthlySavingGoal"
                                    class="text-sm
                                           font-medium
                                           text-[#E2E8F0]"
                                >
                                    Monthly saving goal
                                </label>

                                <span
                                    class="text-xs
                                           text-[#94A3B8]"
                                >
                                    Optional
                                </span>

                            </div>

                            <div class="relative">

                                <span
                                    id="savingCurrencySymbol"
                                    class="absolute
                                           left-4
                                           top-1/2
                                           -translate-y-1/2
                                           text-blue-400
                                           font-semibold"
                                >
                                    ₨
                                </span>

                                <input
                                    type="number"
                                    name="monthly_saving_goal"
                                    id="monthlySavingGoal"
                                    min="0"
                                    step="0.01"
                                    placeholder="10,000"
                                    class="input-field
                                           w-full
                                           rounded-xl
                                           pl-10
                                           pr-4
                                           py-3"
                                >

                            </div>

                            <div
                                id="savingPresets"
                                class="flex
                                       flex-wrap
                                       gap-2
                                       mt-3"
                            >

                                <button
                                    type="button"
                                    class="saving-preset
                                           px-3
                                           py-1.5
                                           rounded-lg
                                           text-xs"
                                    data-value="500"
                                >
                                    ₨500
                                </button>

                                <button
                                    type="button"
                                    class="saving-preset
                                           px-3
                                           py-1.5
                                           rounded-lg
                                           text-xs"
                                    data-value="1000"
                                >
                                    ₨1,000
                                </button>

                                <button
                                    type="button"
                                    class="saving-preset
                                           px-3
                                           py-1.5
                                           rounded-lg
                                           text-xs"
                                    data-value="2500"
                                >
                                    ₨2,500
                                </button>

                                <button
                                    type="button"
                                    class="saving-preset
                                           px-3
                                           py-1.5
                                           rounded-lg
                                           text-xs"
                                    data-value="5000"
                                >
                                    ₨5,000
                                </button>

                            </div>

                            <div
                                id="savingGoalPreview"
                                class="saving-goal-box
                                       hidden
                                       mt-4
                                       rounded-xl
                                       p-4"
                            >

                                <div
                                    class="flex
                                           items-center
                                           gap-3"
                                >

                                    <div
                                        class="w-10
                                               h-10
                                               rounded-xl
                                               flex
                                               items-center
                                               justify-center
                                               bg-blue-500/10
                                               text-blue-400
                                               font-bold"
                                        id="savingPreviewSymbol"
                                    >
                                        ₨
                                    </div>

                                    <div class="flex-1">

                                        <p
                                            class="text-xs
                                                   text-[#94A3B8]"
                                        >
                                            Your monthly target
                                        </p>

                                        <p
                                            id="savingGoalAmount"
                                            class="text-lg
                                                   font-semibold
                                                   text-[#E2E8F0]"
                                        >
                                            ₨0
                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <p
                                            class="text-xs
                                                   text-[#94A3B8]"
                                        >
                                            Daily target
                                        </p>

                                        <p
                                            id="dailySavingGoal"
                                            class="text-sm
                                                   font-semibold
                                                   text-blue-400"
                                        >
                                            ₨0/day
                                        </p>

                                    </div>

                                </div>

                                <div class="mt-3">

                                    <div
                                        class="h-1.5
                                               rounded-full
                                               bg-white/5
                                               overflow-hidden"
                                    >

                                        <div
                                            id="savingGoalBar"
                                            class="h-full
                                                   rounded-full
                                                   bg-blue-500"
                                            style="width: 0%"
                                        ></div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="mt-4">

                            <label
                                for="signupPassword"
                                class="text-sm
                                       font-medium
                                       text-[#E2E8F0]"
                            >
                                Password
                            </label>

                            <div class="relative">

                                <input
                                    type="password"
                                    name="password"
                                    id="signupPassword"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Create a strong password"
                                    class="input-field
                                           w-full
                                           mt-2
                                           rounded-xl
                                           px-4
                                           py-3
                                           pr-14"
                                >

                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="password-toggle"
                                    aria-label="Show password"
                                    title="Show password"
                                >

                                    <svg
                                        class="eye-open-icon"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                                        <circle cx="12" cy="12" r="2.5"></circle>
                                    </svg>

                                    <svg
                                        class="eye-closed-icon hidden"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M3 3l18 18"></path>
                                        <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6.5 0 10 6 10 6a17.7 17.7 0 0 1-3.1 3.9"></path>
                                        <path d="M6.2 6.2C3.5 8.1 2 12 2 12s3.5 6 10 6c1.7 0 3.2-.4 4.5-1"></path>
                                        <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path>
                                    </svg>

                                </button>

                            </div>

                        </div>

                        <div
                            class="mt-5
                                   flex
                                   items-center
                                   gap-5"
                        >

                            <div class="radar">

                                <div class="radar-circle"></div>
                                <div class="radar-circle"></div>
                                <div class="radar-circle"></div>

                                <div
                                    class="radar-line-horizontal"
                                ></div>

                                <div
                                    class="radar-line-vertical"
                                ></div>

                                <div class="radar-sweep"></div>

                            </div>

                            <div class="flex-1">

                                <div
                                    class="flex
                                           justify-between
                                           text-xs
                                           mb-2"
                                >

                                    <span
                                        class="text-[#94A3B8]"
                                    >
                                        Password security
                                    </span>

                                    <span
                                        id="strengthText"
                                        class="text-[#94A3B8]"
                                    >
                                        Waiting...
                                    </span>

                                </div>

                                <div class="strength-bar">

                                    <div
                                        id="strengthFill"
                                        class="strength-fill"
                                    ></div>

                                </div>

                                <div
                                    class="mt-3
                                           space-y-1
                                           text-xs"
                                >

                                    <p
                                        id="lengthCheck"
                                        class="text-[#94A3B8]"
                                    >
                                        ○ 8+ characters
                                    </p>

                                    <p
                                        id="numberCheck"
                                        class="text-[#94A3B8]"
                                    >
                                        ○ Number
                                    </p>

                                    <p
                                        id="specialCheck"
                                        class="text-[#94A3B8]"
                                    >
                                        ○ Special character
                                    </p>

                                    <p
                                        id="upperCheck"
                                        class="text-[#94A3B8]"
                                    >
                                        ○ Uppercase letter
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="mt-4">

                            <label
                                for="confirmPassword"
                                class="text-sm
                                       font-medium
                                       text-[#E2E8F0]"
                            >
                                Confirm password
                            </label>

                            <div class="relative">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="confirmPassword"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Repeat your password"
                                    class="input-field
                                           w-full
                                           mt-2
                                           rounded-xl
                                           px-4
                                           py-3
                                           pr-14"
                                >

                                <button
                                    type="button"
                                    id="toggleConfirmPassword"
                                    class="password-toggle"
                                    aria-label="Show confirm password"
                                    title="Show confirm password"
                                >

                                    <svg
                                        class="eye-open-icon"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                                        <circle cx="12" cy="12" r="2.5"></circle>
                                    </svg>

                                    <svg
                                        class="eye-closed-icon hidden"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M3 3l18 18"></path>
                                        <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6.5 0 10 6 10 6a17.7 17.7 0 0 1-3.1 3.9"></path>
                                        <path d="M6.2 6.2C3.5 8.1 2 12 2 12s3.5 6 10 6c1.7 0 3.2-.4 4.5-1"></path>
                                        <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path>
                                    </svg>

                                </button>

                            </div>

                            <p
                                id="passwordMatch"
                                class="text-xs mt-2"
                            ></p>

                        </div>

                        <button
                            type="submit"
                            id="registerButton"
                            class="main-button
                                   w-full
                                   mt-6
                                   py-3.5
                                   rounded-xl
                                   text-white
                                   font-semibold"
                        >

                            <span class="relative z-10">
                                Create my account →
                            </span>

                        </button>

                        <p
                            class="text-center
                                   text-sm
                                   text-[#94A3B8]
                                   mt-5"
                        >

                            Already have an account?

                            <a
                                href="{{ route('login') }}"
                                class="text-blue-400
                                       font-medium
                                       hover:text-blue-300
                                       transition"
                            >
                                Login
                            </a>

                        </p>

                    </form>

                </section>

            </div>

        </div>

    </main>

    <script>

        const robot =
            document.getElementById("robot");

        const robotMessage =
            document.getElementById("robotMessage");

        const password =
            document.getElementById("signupPassword");

        const confirmPassword =
            document.getElementById("confirmPassword");

        const togglePassword =
            document.getElementById("togglePassword");

        const toggleConfirmPassword =
            document.getElementById("toggleConfirmPassword");

        const strengthFill =
            document.getElementById("strengthFill");

        const strengthText =
            document.getElementById("strengthText");

        const currency =
            document.getElementById("currency");

        const currencySymbol =
            document.getElementById("currencySymbol");

        const currencyName =
            document.getElementById("currencyName");

        const currencyCode =
            document.getElementById("currencyCode");

        const savingCurrencySymbol =
            document.getElementById(
                "savingCurrencySymbol"
            );

        const savingPreviewSymbol =
            document.getElementById(
                "savingPreviewSymbol"
            );

        const monthlySavingGoal =
            document.getElementById(
                "monthlySavingGoal"
            );

        const savingGoalPreview =
            document.getElementById(
                "savingGoalPreview"
            );

        const savingGoalAmount =
            document.getElementById(
                "savingGoalAmount"
            );

        const dailySavingGoal =
            document.getElementById(
                "dailySavingGoal"
            );

        const savingGoalBar =
            document.getElementById(
                "savingGoalBar"
            );

        const savingPresets =
            document.querySelectorAll(
                ".saving-preset"
            );

        const currencyDefaults = {

            PKR: {
                symbol: "₨",
                presets: [500, 1000, 2500, 5000],
                placeholder: "10,000"
            },

            USD: {
                symbol: "$",
                presets: [25, 50, 100, 250],
                placeholder: "100"
            },

            EUR: {
                symbol: "€",
                presets: [25, 50, 100, 250],
                placeholder: "100"
            },

            GBP: {
                symbol: "£",
                presets: [25, 50, 100, 250],
                placeholder: "100"
            },

            INR: {
                symbol: "₹",
                presets: [1000, 2500, 5000, 10000],
                placeholder: "5,000"
            },

            BDT: {
                symbol: "৳",
                presets: [1000, 2500, 5000, 10000],
                placeholder: "5,000"
            },

            CNY: {
                symbol: "¥",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            JPY: {
                symbol: "¥",
                presets: [3000, 5000, 10000, 20000],
                placeholder: "10,000"
            },

            KRW: {
                symbol: "₩",
                presets: [30000, 50000, 100000, 200000],
                placeholder: "100,000"
            },

            IDR: {
                symbol: "Rp",
                presets: [100000, 250000, 500000, 1000000],
                placeholder: "500,000"
            },

            MYR: {
                symbol: "RM",
                presets: [50, 100, 250, 500],
                placeholder: "100"
            },

            SGD: {
                symbol: "S$",
                presets: [50, 100, 250, 500],
                placeholder: "100"
            },

            THB: {
                symbol: "฿",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            VND: {
                symbol: "₫",
                presets: [500000, 1000000, 2500000, 5000000],
                placeholder: "1,000,000"
            },

            PHP: {
                symbol: "₱",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            HKD: {
                symbol: "HK$",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            TWD: {
                symbol: "NT$",
                presets: [1000, 2500, 5000, 10000],
                placeholder: "5,000"
            },

            AED: {
                symbol: "د.إ",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            SAR: {
                symbol: "﷼",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            QAR: {
                symbol: "﷼",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            KWD: {
                symbol: "د.ك",
                presets: [10, 25, 50, 100],
                placeholder: "50"
            },

            BHD: {
                symbol: ".د.ب",
                presets: [10, 25, 50, 100],
                placeholder: "50"
            },

            OMR: {
                symbol: "﷼",
                presets: [10, 25, 50, 100],
                placeholder: "50"
            },

            JOD: {
                symbol: "د.ا",
                presets: [25, 50, 100, 250],
                placeholder: "100"
            },

            ILS: {
                symbol: "₪",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            TRY: {
                symbol: "₺",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            CHF: {
                symbol: "CHF",
                presets: [50, 100, 250, 500],
                placeholder: "100"
            },

            NOK: {
                symbol: "kr",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            SEK: {
                symbol: "kr",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            DKK: {
                symbol: "kr",
                presets: [250, 500, 1000, 2500],
                placeholder: "500"
            },

            PLN: {
                symbol: "zł",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            CZK: {
                symbol: "Kč",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            HUF: {
                symbol: "Ft",
                presets: [5000, 10000, 25000, 50000],
                placeholder: "10,000"
            },

            RON: {
                symbol: "lei",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            UAH: {
                symbol: "₴",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            CAD: {
                symbol: "C$",
                presets: [50, 100, 250, 500],
                placeholder: "100"
            },

            AUD: {
                symbol: "A$",
                presets: [50, 100, 250, 500],
                placeholder: "100"
            },

            NZD: {
                symbol: "NZ$",
                presets: [50, 100, 250, 500],
                placeholder: "100"
            },

            MXN: {
                symbol: "MX$",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            BRL: {
                symbol: "R$",
                presets: [100, 250, 500, 1000],
                placeholder: "500"
            },

            ARS: {
                symbol: "$",
                presets: [10000, 25000, 50000, 100000],
                placeholder: "50,000"
            },

            CLP: {
                symbol: "$",
                presets: [10000, 25000, 50000, 100000],
                placeholder: "50,000"
            },

            ZAR: {
                symbol: "R",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            },

            EGP: {
                symbol: "E£",
                presets: [1000, 2500, 5000, 10000],
                placeholder: "5,000"
            },

            NGN: {
                symbol: "₦",
                presets: [10000, 25000, 50000, 100000],
                placeholder: "50,000"
            },

            KES: {
                symbol: "KSh",
                presets: [1000, 2500, 5000, 10000],
                placeholder: "5,000"
            },

            GHS: {
                symbol: "GH₵",
                presets: [500, 1000, 2500, 5000],
                placeholder: "1,000"
            }

        };

        function formatMoney(amount) {

            const selectedOption =
                currency.options[
                    currency.selectedIndex
                ];

            const code =
                selectedOption.value;

            const data =
                currencyDefaults[code];

            if (!data) {
                return amount;
            }

            return (
                data.symbol +
                Number(amount).toLocaleString(
                    undefined,
                    {
                        maximumFractionDigits: 2
                    }
                )
            );
        }

        function updateCurrency() {

            const selectedOption =
                currency.options[
                    currency.selectedIndex
                ];

            const code =
                selectedOption.value;

            const symbol =
                selectedOption.dataset.symbol;

            const name =
                selectedOption.dataset.name;

            const data =
                currencyDefaults[code];

            currencySymbol.textContent =
                symbol;

            savingCurrencySymbol.textContent =
                symbol;

            savingPreviewSymbol.textContent =
                symbol;

            currencyName.textContent =
                name;

            currencyCode.textContent =
                code;

            if (data) {

                monthlySavingGoal.placeholder =
                    data.placeholder;

            }

            if (data) {

                savingPresets.forEach(
                    (button, index) => {

                        const value =
                            data.presets[index];

                        button.dataset.value =
                            value;

                        button.textContent =
                            formatMoney(value);

                    }
                );

            }

            if (monthlySavingGoal.value) {

                updateSavingGoal(
                    monthlySavingGoal.value
                );

            }

            robotMessage.textContent =
                "Great! I'll track your finances in " +
                name +
                ".";

        }

        currency.addEventListener(
            "change",
            updateCurrency
        );

        function updateSavingGoal(value) {

            const amount =
                parseFloat(value);

            if (
                !amount ||
                amount <= 0
            ) {

                savingGoalPreview.classList.add(
                    "hidden"
                );

                savingGoalBar.style.width =
                    "0%";

                return;
            }

            const daily =
                amount / 30;

            savingGoalPreview.classList.remove(
                "hidden"
            );

            savingGoalAmount.textContent =
                formatMoney(amount);

            dailySavingGoal.textContent =
                formatMoney(daily) +
                "/day";

            const progress =
                Math.min(
                    100,
                    Math.max(
                        10,
                        (amount / 5000) * 100
                    )
                );

            savingGoalBar.style.width =
                progress + "%";

            if (amount < 100) {

                robotMessage.textContent =
                    "Every little bit counts. Let's build your savings habit!";

            }

            else if (amount < 500) {

                robotMessage.textContent =
                    "Nice goal! Small monthly savings can add up.";

            }

            else if (amount < 2500) {

                robotMessage.textContent =
                    "Great target! I'll help you stay on track.";

            }

            else {

                robotMessage.textContent =
                    "That's an ambitious goal. Let's make it happen!";

            }

        }

        monthlySavingGoal.addEventListener(
            "input",
            function() {

                updateSavingGoal(
                    this.value
                );

                savingPresets.forEach(
                    button => {

                        button.classList.remove(
                            "selected"
                        );

                    }
                );

            }
        );

        savingPresets.forEach(
            button => {

                button.addEventListener(
                    "click",
                    function() {

                        const value =
                            this.dataset.value;

                        monthlySavingGoal.value =
                            value;

                        updateSavingGoal(
                            value
                        );

                        savingPresets.forEach(
                            item => {

                                item.classList.remove(
                                    "selected"
                                );

                            }
                        );

                        this.classList.add(
                            "selected"
                        );

                    }
                );

            }
        );

        const pupils =
            document.querySelectorAll(
                ".eye-pupil"
            );

        document.addEventListener(
            "mousemove",
            function(event) {

                const mouseX =
                    event.clientX;

                const mouseY =
                    event.clientY;

                pupils.forEach(
                    function(pupil) {

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

                        const angle =
                            Math.atan2(
                                mouseY - centerY,
                                mouseX - centerX
                            );

                        const distance =
                            Math.min(
                                9,
                                Math.hypot(
                                    mouseX - centerX,
                                    mouseY - centerY
                                ) / 30
                            );

                        const x =
                            Math.cos(angle) *
                            distance;

                        const y =
                            Math.sin(angle) *
                            distance;

                        pupil.style.transform =
                            `translate(${x}px, ${y}px)`;

                    }
                );

            }
        );

        function updateRobotEyeState() {

            const passwordVisible =
                password.type === "text";

            const confirmVisible =
                confirmPassword.type === "text";

            if (
                passwordVisible ||
                confirmVisible
            ) {

                robot.classList.add(
                    "password-mode"
                );

            } else {

                robot.classList.remove(
                    "password-mode"
                );

            }

        }

        function updateToggleIcon(
            button,
            input,
            label
        ) {

            const openIcon =
                button.querySelector(
                    ".eye-open-icon"
                );

            const closedIcon =
                button.querySelector(
                    ".eye-closed-icon"
                );

            const isVisible =
                input.type === "text";

            if (isVisible) {

                openIcon.classList.add(
                    "hidden"
                );

                closedIcon.classList.remove(
                    "hidden"
                );

                button.setAttribute(
                    "aria-label",
                    "Hide " + label
                );

                button.setAttribute(
                    "title",
                    "Hide " + label
                );

            } else {

                openIcon.classList.remove(
                    "hidden"
                );

                closedIcon.classList.add(
                    "hidden"
                );

                button.setAttribute(
                    "aria-label",
                    "Show " + label
                );

                button.setAttribute(
                    "title",
                    "Show " + label
                );

            }

            updateRobotEyeState();

        }

        togglePassword.addEventListener(
            "click",
            function() {

                if (
                    password.type ===
                    "password"
                ) {

                    password.type =
                        "text";

                } else {

                    password.type =
                        "password";

                }

                updateToggleIcon(
                    togglePassword,
                    password,
                    "password"
                );

            }
        );

        toggleConfirmPassword.addEventListener(
            "click",
            function() {

                if (
                    confirmPassword.type ===
                    "password"
                ) {

                    confirmPassword.type =
                        "text";

                } else {

                    confirmPassword.type =
                        "password";

                }

                updateToggleIcon(
                    toggleConfirmPassword,
                    confirmPassword,
                    "confirm password"
                );

            }
        );

        password.addEventListener(
            "focus",
            function() {

                robotMessage.textContent =
                    "I'll protect your password. Make it strong!";

            }
        );

        confirmPassword.addEventListener(
            "focus",
            function() {

                robotMessage.textContent =
                    "Let's make sure both passwords match.";

            }
        );

        password.addEventListener(
            "input",
            function() {

                const value =
                    password.value;

                if (value.length === 0) {

                    strengthFill.style.width =
                        "0%";

                    strengthText.textContent =
                        "Waiting...";

                    strengthText.style.color =
                        "#94A3B8";

                    resetPasswordChecks();

                    return;
                }

                let score = 0;

                const hasLength =
                    value.length >= 8;

                const hasNumber =
                    /\d/.test(value);

                const hasSpecial =
                    /[^A-Za-z0-9]/.test(value);

                const hasUpper =
                    /[A-Z]/.test(value);

                if (hasLength) score++;
                if (hasNumber) score++;
                if (hasSpecial) score++;
                if (hasUpper) score++;

                updateCheck(
                    "lengthCheck",
                    hasLength,
                    "8+ characters"
                );

                updateCheck(
                    "numberCheck",
                    hasNumber,
                    "Number"
                );

                updateCheck(
                    "specialCheck",
                    hasSpecial,
                    "Special character"
                );

                updateCheck(
                    "upperCheck",
                    hasUpper,
                    "Uppercase letter"
                );

                if (score <= 1) {

                    updateStrength(
                        "25%",
                        "rgba(59,130,246,.45)",
                        "Weak"
                    );

                    robotMessage.textContent =
                        "That's a little weak. Let's make it stronger.";

                }

                else if (score === 2) {

                    updateStrength(
                        "50%",
                        "rgba(59,130,246,.65)",
                        "Fair"
                    );

                    robotMessage.textContent =
                        "Getting better. Add a little more security.";

                }

                else if (score === 3) {

                    updateStrength(
                        "75%",
                        "#3B82F6",
                        "Good"
                    );

                    robotMessage.textContent =
                        "Nice! Your password is getting strong.";

                }

                else {

                    updateStrength(
                        "100%",
                        "#3B82F6",
                        "Strong"
                    );

                    robotMessage.textContent =
                        "Excellent! That's a strong password.";

                }

            }
        );

        function updateStrength(
            width,
            color,
            text
        ) {

            strengthFill.style.width =
                width;

            strengthFill.style.background =
                color;

            strengthText.textContent =
                text;

            strengthText.style.color =
                "#E2E8F0";
        }

        function updateCheck(
            id,
            valid,
            text
        ) {

            const element =
                document.getElementById(id);

            if (valid) {

                element.textContent =
                    "✓ " + text;

                element.style.color =
                    "#E2E8F0";

            } else {

                element.textContent =
                    "○ " + text;

                element.style.color =
                    "#94A3B8";

            }

        }

        function resetPasswordChecks() {

            updateCheck(
                "lengthCheck",
                false,
                "8+ characters"
            );

            updateCheck(
                "numberCheck",
                false,
                "Number"
            );

            updateCheck(
                "specialCheck",
                false,
                "Special character"
            );

            updateCheck(
                "upperCheck",
                false,
                "Uppercase letter"
            );

        }

        confirmPassword.addEventListener(
            "input",
            function() {

                const message =
                    document.getElementById(
                        "passwordMatch"
                    );

                if (!confirmPassword.value) {

                    message.textContent = "";

                    return;
                }

                if (
                    password.value ===
                    confirmPassword.value
                ) {

                    message.textContent =
                        "✓ Passwords match";

                    message.style.color =
                        "#E2E8F0";

                    robotMessage.textContent =
                        "Perfect! Your passwords match.";

                } else {

                    message.textContent =
                        "✕ Passwords do not match";

                    message.style.color =
                        "#94A3B8";

                }

            }
        );

        document
            .getElementById("registerForm")
            .addEventListener(
                "submit",
                function(event) {

                    if (
                        password.value !==
                        confirmPassword.value
                    ) {

                        event.preventDefault();

                        robotMessage.textContent =
                            "Oops! Your passwords don't match.";

                        confirmPassword.focus();

                        return;
                    }

                    robotMessage.textContent =
                        "Creating your Campus Coin account...";

                }
            );

        updateCurrency();

        updateToggleIcon(
            togglePassword,
            password,
            "password"
        );

        updateToggleIcon(
            toggleConfirmPassword,
            confirmPassword,
            "confirm password"
        );

    </script>

</body>

</html>