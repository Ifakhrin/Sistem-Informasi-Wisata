<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - Travel Insight AI</title>

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
            padding: 42px 9%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 500px;
            background: rgba(255,255,255,0.96);
            border: 1px solid #e2e8f0;
            border-radius: 28px;
            padding: 38px;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.12);
        }

        .brand-mobile {
            display: none;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 28px;
        }

        .brand-icon-mobile {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            display: grid;
            place-items: center;
            color: white;
            font-weight: 900;
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

        .password-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e3a8a;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 13px;
            line-height: 1.6;
            margin: 6px 0 22px;
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

        .login-box {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .login-box a {
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

        .right-panel {
            padding: 48px 9%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .right-panel::before {
            content: "";
            position: absolute;
            width: 430px;
            height: 430px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            top: -150px;
            left: -120px;
        }

        .right-panel::after {
            content: "";
            position: absolute;
            width: 310px;
            height: 310px;
            border-radius: 50%;
            background: rgba(255,255,255,0.10);
            bottom: -110px;
            right: -90px;
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
            margin: 0 0 28px;
        }

        .feature-list {
            display: grid;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.13);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 16px;
            padding: 14px 16px;
            color: rgba(255,255,255,0.92);
            font-size: 14px;
            font-weight: 750;
        }

        .feature-item span {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255,255,255,0.18);
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        .right-footer {
            position: relative;
            z-index: 2;
            font-size: 13px;
            color: rgba(255,255,255,0.75);
        }

        @media (max-width: 900px) {
            .page {
                grid-template-columns: 1fr;
            }

            .right-panel {
                display: none;
            }

            .left-panel {
                padding: 28px 20px;
            }

            .auth-card {
                padding: 28px;
                border-radius: 22px;
            }

            .brand-mobile {
                display: flex;
            }

            .auth-header h2 {
                font-size: 30px;
            }

            .password-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <section class="left-panel">
            <div class="auth-card">
                <a href="{{ route('home') }}" class="brand-mobile">
                    <span class="brand-icon-mobile">✦</span>
                    <span>Travel Insight AI</span>
                </a>

                <div class="top-link">
                    <a href="{{ route('login') }}">Already have an account?</a>
                </div>

                <div class="auth-header">
                    <h2>Create Account</h2>
                    <p>
                        Register to start exploring AI-powered tourism recommendations across Indonesia.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input
                            id="name"
                            class="form-control"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Enter your full name"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input
                            id="email"
                            class="form-control"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div class="password-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input
                                id="password"
                                class="form-control"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Create password"
                            >
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input
                                id="password_confirmation"
                                class="form-control"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm password"
                            >
                        </div>
                    </div>

                    <div class="info-box">
                        Your account will be used to save travel plans, access AI recommendations,
                        and personalize your destination exploration.
                    </div>

                    <button type="submit" class="btn-primary">
                        Create Account
                    </button>
                </form>

                <div class="divider">or</div>

                <div class="login-box">
                    Already registered?
                    <a href="{{ route('login') }}">Sign in to your account</a>
                </div>

                <div class="back-home">
                    <a href="{{ route('home') }}">← Back to Home</a>
                </div>
            </div>
        </section>

        <section class="right-panel">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-icon">✦</span>
                <span>Travel Insight AI</span>
            </a>

            <div class="hero-copy">
                <div class="badge">Start Your Journey</div>

                <h1>
                    Discover destinations that match your travel style.
                </h1>

                <p>
                    Create your account to access AI Assistant, smart recommendation scoring,
                    tourism maps, and saved travel plans.
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <span>✦</span>
                        AI-powered destination recommendations
                    </div>

                    <div class="feature-item">
                        <span>⌖</span>
                        Explore destinations by category and location
                    </div>

                    <div class="feature-item">
                        <span>♡</span>
                        Save favorite destinations into travel plans
                    </div>
                </div>
            </div>

            <div class="right-footer">
                © {{ date('Y') }} TravelInsight AI. All rights reserved.
            </div>
        </section>
    </main>
</body>
</html>
