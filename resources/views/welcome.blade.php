<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Insight AI</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            height: 74px;
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 9%;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(14px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            display: grid;
            place-items: center;
            color: white;
            font-weight: 900;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .nav-links a {
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 900;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
        }

        .btn-secondary {
            background: white;
            color: #0f172a;
            border-color: #e2e8f0;
        }

        .hero {
            padding: 80px 9% 72px;
            background: linear-gradient(135deg, #f8fbff 0%, #eef8ff 100%);
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
            gap: 70px;
            border-bottom: 1px solid #e2e8f0;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 9px 14px;
            background: #eaf1ff;
            color: #2563eb;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 900;
            margin-bottom: 26px;
        }

        .hero h1 {
            font-size: 52px;
            line-height: 1.12;
            letter-spacing: -1.5px;
            margin: 0 0 20px;
            color: #0f172a;
        }

        .gradient-text {
            background: linear-gradient(90deg, #2563eb, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 18px;
            color: #64748b;
            line-height: 1.8;
            max-width: 720px;
            margin: 0 0 34px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .hero-card {
            background: linear-gradient(135deg, #e0f2fe, #f0fdfa);
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 30px 55px rgba(15, 23, 42, 0.18);
        }

        .hero-card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 18px;
            display: block;
        }

        .stats {
            background: white;
            padding: 58px 9%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 26px;
            border-bottom: 1px solid #e2e8f0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #eaf1ff;
            color: #2563eb;
            display: grid;
            place-items: center;
            margin: 0 auto 12px;
            font-size: 18px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 950;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 700;
        }

        .section {
            padding: 70px 9%;
        }

        .section-header {
            text-align: center;
            max-width: 720px;
            margin: 0 auto 54px;
        }

        .section-label {
            display: inline-block;
            padding: 7px 12px;
            background: #cffafe;
            color: #0891b2;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            margin-bottom: 16px;
        }

        .section-header h2 {
            font-size: 36px;
            letter-spacing: -0.8px;
            margin: 0 0 14px;
            color: #0f172a;
        }

        .section-header p {
            font-size: 16px;
            color: #64748b;
            line-height: 1.7;
            margin: 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 26px;
        }

        .feature-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 28px;
            min-height: 210px;
            transition: 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08);
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: #eaf1ff;
            color: #2563eb;
            display: grid;
            place-items: center;
            margin-bottom: 22px;
            font-size: 18px;
        }

        .feature-card h3 {
            margin: 0 0 14px;
            font-size: 17px;
            font-weight: 950;
            color: #0f172a;
        }

        .feature-card p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            margin-top: 20px;
        }

        .destination-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
        }

        .destination-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            display: block;
        }

        .destination-body {
            padding: 22px;
        }

        .destination-body h3 {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 950;
            color: #0f172a;
        }

        .destination-body p {
            margin: 0 0 18px;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .destination-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .tag {
            background: #dcfce7;
            color: #059669;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 900;
        }

        .rating {
            color: #f59e0b;
            font-size: 13px;
            font-weight: 900;
        }

        .cta {
            padding: 82px 9%;
            text-align: center;
            color: white;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
        }

        .cta-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            margin: 0 auto 22px;
            background: rgba(255, 255, 255, 0.2);
            font-size: 28px;
        }

        .cta h2 {
            font-size: 38px;
            line-height: 1.16;
            margin: 0 0 22px;
            letter-spacing: -0.8px;
        }

        .cta p {
            font-size: 17px;
            line-height: 1.7;
            margin: 0 0 28px;
            color: rgba(255, 255, 255, 0.88);
        }

        .btn-cta {
            background: #06b6d4;
            color: white;
            border-radius: 999px;
            padding: 13px 20px;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.18);
        }

        .footer {
            background: white;
            padding: 48px 9% 28px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 36px;
            border-bottom: 1px solid #e2e8f0;
        }

        .footer h4 {
            margin: 0 0 16px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 950;
        }

        .footer p,
        .footer a {
            color: #64748b;
            font-size: 14px;
            line-height: 1.8;
        }

        .footer a {
            display: block;
            margin-bottom: 8px;
        }

        .copyright {
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            padding-top: 24px;
        }

        @media (max-width: 900px) {
            .navbar {
                padding: 0 22px;
            }

            .nav-links a:not(.btn) {
                display: none;
            }

            .hero {
                grid-template-columns: 1fr;
                padding: 58px 22px;
            }

            .hero h1 {
                font-size: 40px;
            }

            .stats,
            .features-grid,
            .destinations-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .section,
            .cta,
            .footer {
                padding-left: 22px;
                padding-right: 22px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-icon">✦</span>
            <span>Travel Insight AI</span>
        </a>

        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#destinations">Destinations</a>

            <a href="{{ route('login') }}" class="btn btn-secondary" style="padding: 10px 16px;">
                Sign In
            </a>

            <a href="{{ route('register') }}" class="btn btn-primary text-white" style="padding: 10px 16px;">
                Get Started
            </a>
        </div>
    </nav>

    <section class="hero">
        <div>
            <div class="badge">AI-Powered Travel Platform</div>

            <h1>
                Discover Indonesia with <br>
                <span class="gradient-text">Artificial Intelligence</span>
            </h1>

            <p>
                Get personalized tourism recommendations powered by AI. Explore hidden gems,
                plan perfect itineraries, and discover destinations tailored just for you.
            </p>

            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Start Exploring ›
                </a>

                <a href="{{ route('login') }}" class="btn btn-secondary">
                    ✧ Try AI Assistant
                </a>
            </div>
        </div>

        <div class="hero-card">
            <img src="{{ asset('images/categories/budaya.jpg') }}" alt="Indonesia Tourism">
        </div>
    </section>

    <section class="stats">
        <div class="stat-item">
            <div class="stat-icon">⌖</div>
            <div class="stat-number">{{ number_format($totalDestinasi ?? 0) }}+</div>
            <div class="stat-label">Destinations</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">♙</div>
            <div class="stat-number">50,000+</div>
            <div class="stat-label">Happy Travelers</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">✦</div>
            <div class="stat-number">1M+</div>
            <div class="stat-label">AI Recommendations</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">☆</div>
            <div class="stat-number">4.9</div>
            <div class="stat-label">Average Rating</div>
        </div>
    </section>

    <section id="features" class="section">
        <div class="section-header">
            <span class="section-label">Features</span>
            <h2>Why Choose TravelInsight AI?</h2>
            <p>
                Experience the future of travel planning with our advanced AI technology.
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">✦</div>
                <h3>AI-Powered Recommendations</h3>
                <p>
                    Get personalized travel suggestions based on your preferences, budget,
                    and interests using advanced AI technology.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">◎</div>
                <h3>Smart Destination Matching</h3>
                <p>
                    Our AI analyzes your travel style and matches you with perfect destinations
                    across Indonesia.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">↗</div>
                <h3>Travel Insights</h3>
                <p>
                    Discover trending destinations and hidden gems with AI-generated insights
                    and analytics.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">▣</div>
                <h3>Trusted & Verified</h3>
                <p>
                    All recommendations are based on verified destination data and traveler
                    rating datasets.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Instant Planning</h3>
                <p>
                    Create complete travel recommendations in seconds with our AI travel assistant.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">◎</div>
                <h3>Explore Indonesia</h3>
                <p>
                    Access comprehensive information about tourist attractions across Indonesian
                    cities and provinces.
                </p>
            </div>
        </div>
    </section>

    <section id="destinations" class="section" style="padding-top: 30px;">
        <div class="section-header">
            <h2>Popular Destinations</h2>
            <p>Discover Indonesia's most visited tourist attractions</p>
        </div>

        <div class="destinations-grid">
            <div class="destination-card">
                <img src="{{ asset('images/categories/budaya.jpg') }}" alt="Cultural Heritage">
                <div class="destination-body">
                    <h3>Cultural Destinations</h3>
                    <p>Indonesia</p>
                    <div class="destination-meta">
                        <span class="tag">Cultural Heritage</span>
                        <span class="rating">☆ 4.8</span>
                    </div>
                </div>
            </div>

            <div class="destination-card">
                <img src="{{ asset('images/categories/bahari.jpg') }}" alt="Natural Wonder">
                <div class="destination-body">
                    <h3>Marine Destinations</h3>
                    <p>Indonesia</p>
                    <div class="destination-meta">
                        <span class="tag">Natural Wonder</span>
                        <span class="rating">☆ 4.9</span>
                    </div>
                </div>
            </div>

            <div class="destination-card">
                <img src="{{ asset('images/categories/cagar_alam.jpg') }}" alt="Mountain and Nature">
                <div class="destination-body">
                    <h3>Nature Destinations</h3>
                    <p>Indonesia</p>
                    <div class="destination-meta">
                        <span class="tag">Nature & Adventure</span>
                        <span class="rating">☆ 4.7</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-icon">♡</div>

        <h2>
            Ready to Discover Your Perfect Indonesian <br>
            Adventure?
        </h2>

        <p>
            Join thousands of travelers who trust our AI to plan their perfect trips.
        </p>

        <a href="{{ route('register') }}" class="btn btn-cta">
            Get Started for Free ›
        </a>
    </section>

    <footer class="footer">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="brand" style="margin-bottom: 14px;">
                    <span class="brand-icon">✦</span>
                    <span>TravelInsight AI</span>
                </a>

                <p>
                    AI-powered tourism recommendation platform for Indonesia.
                </p>
            </div>

            <div>
                <h4>Product</h4>
                <a href="#features">Features</a>
                <a href="#destinations">Destinations</a>
                <a href="{{ route('login') }}">AI Assistant</a>
                <a href="{{ route('register') }}">Pricing</a>
            </div>

            <div>
                <h4>Company</h4>
                <a href="#">About Us</a>
                <a href="#">Blog</a>
                <a href="#">Careers</a>
                <a href="#">Contact</a>
            </div>

            <div>
                <h4>Legal</h4>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>

        <div class="copyright">
            © {{ date('Y') }} TravelInsight AI. All rights reserved.
        </div>
    </footer>
</body>
</html>