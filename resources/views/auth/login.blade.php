<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - Travel Insight AI</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #f8fbff 0%, #eef8ff 100%);
            color: #0f172a;
        }

        a {
            text-decoration: none;
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .left-panel {
            padding: 48px 9%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            top: -140px;
            right: -120px;
        }

        .left-panel::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.10);
            bottom: -100px;
            left: -80px;
        }

        .brand {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 19px;
            font-weight: 900;
            color: white;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,0.18);
            display: grid;
            place-items: center;
            font-weight: 900;
        }

        .hero-copy {
            position: relative;
            z-index: 2;
            max-width: 560px;
        }

        .hero-copy .badge {
            display: inline-flex;
            background: rgba(255,255,255,0.18);
            color: white;
            border-radius: 999px;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 900;
            margin-bottom: 24px;
        }

        .hero-copy h1 {
            font-size: 48px;
            line-height: 1.12;
            letter-spacing: -1.4px;
            margin: 0 0 20px;
        }

        .hero-copy p {
            font-size: 17px;
            line-height: 1.8;
            color: rgba(255,255,255,0.86);
            margin: 0;
        }

        .left-footer {
            position: relative;
            z-index: 2;
            font-size: 13px;
            color: rgba(255,255,255,0.75);
        }

        .right-panel {
            padding: 42px 9%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            background: rgba(255,255,255,0.96);
            border: 1px solid #e2e8f0;
            border-radius: 28px;
            padding: 38px;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.12);
        }

        .top-link {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 24px;
        }

        .top-link a {
            font-size: 14px;
            font-weight: 800;
            color: #2563eb;
        }

        .auth-header {
            margin-bottom: 28px;
        }

        .auth-header h2 {
            font-size: 34px;
            line-height: 1.15;
            margin: 0 0 10px;
            letter-spacing: -0.8px;
            color: #0f172a;
        }

        .auth-header p {
            color: #64748b;
            font-size: 15px;
            line-height: 1.7;
            margin: 0;
        }

        .status-message {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-radius: 14px;
            padding: 12px 14px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 14px;
            padding: 12px 14px;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            color: #334155;
            font-weight: 900;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 15px;
            padding: 13px 15px;
            font-size: 15px;
            color: #0f172a;
            outline: none;
            transition: 0.2s ease;
        }

        .form-control:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 4px 0 24px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #475569;
            font-weight: 700;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: #2563eb;
        }

        .forgot-link {
            font-size: 14px;
            font-weight: 800;
            color: #2563eb;
        }

        .btn-primary {
            width: 100%;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 15px;
            padding: 14px 18px;
            font-size: 15px;
            font-weight: 950;
            cursor: pointer;
            box-shadow: 0 16px 30px rgba(37, 99, 235, 0.22);
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 26px 0;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 800;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .register-box {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .register-box a {
            color: #2563eb;
            font-weight: 900;
        }

        .back-home {
            margin-top: 22px;
            text-align: center;
        }

        .back-home a {
            color: #64748b;
            font-size: 14px;
            font-weight: 800;
        }

        @media (max-width: 900px) {
            .page {
                grid-template-columns: 1fr;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                padding: 28px 20px;
            }

            .auth-card {
                padding: 28px;
                border-radius: 22px;
            }

            .auth-header h2 {
                font-size: 30px;
            }

            .form-row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <section class="left-panel">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-icon">✦</span>
                <span>Travel Insight AI</span>
            </a>

            <div class="hero-copy">
                <div class="badge">AI-Powered Travel Platform</div>

                <h1>
                    Welcome back to your smart travel planner.
                </h1>

                <p>
                    Sign in to access AI recommendations, saved travel plans, destination insights,
                    and tourism maps tailored to your preferences.
                </p>
            </div>

            <div class="left-footer">
                © {{ date('Y') }} TravelInsight AI. All rights reserved.
            </div>
        </section>

        <section class="right-panel">
            <div class="auth-card">
                <div class="top-link">
                    <a href="{{ route('register') }}">Create account</a>
                </div>

                <div class="auth-header">
                    <h2>Sign In</h2>
                    <p>
                        Enter your email and password to continue exploring Indonesian destinations.
                    </p>
                </div>

                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input
                            id="email"
                            class="form-control"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input
                            id="password"
                            class="form-control"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        >
                    </div>

                    <div class="form-row">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary">
                        Sign In
                    </button>
                </form>

                <div class="divider">or</div>

                <div class="register-box">
                    Don’t have an account?
                    <a href="{{ route('register') }}">Get started for free</a>
                </div>

                <div class="back-home">
                    <a href="{{ route('home') }}">← Back to Home</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>