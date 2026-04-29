<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CBT Platform</title>
    @vite(['resources/css/welcome.css'])
</head>

<body>
    <div class="page-shell">
        <div class="ambient ambient-one"></div>
        <div class="ambient ambient-two"></div>
        <div class="ambient ambient-three"></div>

        <header class="site-header">
            <a href="/" class="brand">
                <span class="brand-mark">C</span>
                <span class="brand-text">
                    <strong>CBT Pulse</strong>
                    <small>Smart testing, calm delivery</small>
                </span>
            </a>

            <nav class="site-nav">
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link nav-link-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link nav-link-primary">Create Account</a>
                @endauth
            </nav>
        </header>

        <main class="hero-grid">
            <section class="hero-copy">
                <div class="eyebrow">Next-generation exam experience</div>
                <h1>Run focused computer-based tests with speed, style, and trust.</h1>
                <p class="hero-text">
                    A polished CBT workspace for students, teachers, and admins, built to make assessments feel
                    organized, modern, and confident from the first click.
                </p>

                <div class="hero-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="button button-primary">Open Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="button button-primary">Start Free</a>
                        <a href="{{ route('login') }}" class="button button-secondary">I Have an Account</a>
                    @endauth
                </div>

                <div class="hero-metrics">
                    <article class="metric-card">
                        <span class="metric-value">Live</span>
                        <span class="metric-label">Timed assessments with auto-submit protection</span>
                    </article>
                    <article class="metric-card">
                        <span class="metric-value">Insight</span>
                        <span class="metric-label">Progress tracking, results, and leaderboard-ready flow</span>
                    </article>
                    <article class="metric-card">
                        <span class="metric-value">Secure</span>
                        <span class="metric-label">Tab-switch monitoring and transparent admin visibility</span>
                    </article>
                </div>
            </section>

            <section class="hero-visual">
                <div class="glass-panel panel-main">
                    <div class="panel-top">
                        <span class="status-pill">Exam session active</span>
                        <span class="panel-time">42:18</span>
                    </div>

                    <div class="score-ring">
                        <div class="score-ring-inner">
                            <strong>96%</strong>
                            <span>Preparedness</span>
                        </div>
                    </div>

                    <div class="signal-stack">
                        <div class="signal-card">
                            <span>Focus detection</span>
                            <strong>3-strike policy</strong>
                        </div>
                        <div class="signal-card">
                            <span>Attempt analytics</span>
                            <strong>Instant review trails</strong>
                        </div>
                    </div>
                </div>

                <div class="glass-panel panel-float panel-float-left">
                    <span class="float-label">Student flow</span>
                    <strong>Guided exams</strong>
                    <p>One-question focus, progress palette, smooth navigation.</p>
                </div>

                <div class="glass-panel panel-float panel-float-right">
                    <span class="float-label">Admin pulse</span>
                    <strong>Clear oversight</strong>
                    <p>Monitor attempts, scores, and flagged behavior in one place.</p>
                </div>
            </section>
        </main>

        <section class="feature-strip">
            <article class="feature-card">
                <span class="feature-index">01</span>
                <h2>Elegant student experience</h2>
                <p>Focused layouts, timers, and progress cues that reduce confusion during exams.</p>
            </article>
            <article class="feature-card">
                <span class="feature-index">02</span>
                <h2>Teacher-friendly structure</h2>
                <p>Create exams and questions in a workflow that stays practical as your content grows.</p>
            </article>
            <article class="feature-card">
                <span class="feature-index">03</span>
                <h2>Actionable admin visibility</h2>
                <p>See performance trends, recent attempts, and integrity signals without digging around.</p>
            </article>
        </section>
    </div>
</body>

</html>
