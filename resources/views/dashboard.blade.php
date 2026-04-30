<x-app-layout>
    <x-slot name="header">
        <h2 style="
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #4f8ef7;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        ">
            <span style="display:inline-block;width:20px;height:2px;background:#4f8ef7;border-radius:99px;"></span>
            Workspace
        </h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Sora:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* override Breeze's body/bg */
        body, .bg-gray-100 { background: #080a0f !important; }

        .piq-workspace {
            padding: 40px 32px 80px;
            max-width: 1280px;
            margin: 0 auto;
        }

        .piq-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 16px;
        }

        .piq-card {
            background: #13161e;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px;
            padding: 36px 40px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.2s ease;
        }

        .piq-card:hover {
            border-color: rgba(255,255,255,0.12);
        }

        /* accent top line by role */
        .piq-card-main[data-role="admin"]   { border-top: 2px solid #4f8ef7; }
        .piq-card-main[data-role="teacher"] { border-top: 2px solid #a78bfa; }
        .piq-card-main[data-role="student"] { border-top: 2px solid #c8f135; }

        /* subtle glow bg */
        .piq-card-main::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(200,241,53,0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .piq-role-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #c8f135;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .piq-role-tag::before {
            content: '';
            width: 18px; height: 1px;
            background: #c8f135;
        }

        .piq-welcome {
            font-family: 'Sora', sans-serif;
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 700;
            color: #f0f2f5;
            line-height: 1.15;
            margin-bottom: 12px;
        }

        .piq-welcome span {
            color: #c8f135;
        }

        .piq-desc {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 300;
            color: #7a8099;
            line-height: 1.7;
            max-width: 440px;
            margin-bottom: 32px;
        }

        .piq-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .piq-btn {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 11px 22px;
            border-radius: 6px;
            border: 1px solid transparent;
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .piq-btn-primary {
            background: #c8f135;
            color: #080a0f;
            border-color: #c8f135;
        }

        .piq-btn-primary:hover {
            background: #d4f550;
            box-shadow: 0 0 28px rgba(200,241,53,0.3);
            transform: translateY(-2px);
        }

        .piq-btn-primary::after { content: ' →'; }

        .piq-btn-secondary {
            background: #1a1e2a;
            color: #8892a4;
            border-color: rgba(255,255,255,0.08);
        }

        .piq-btn-secondary:hover {
            color: #f0f2f5;
            border-color: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        /* Account card */
        .piq-account-title {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #3a4155;
            margin-bottom: 24px;
        }

        .piq-account-row {
            margin-bottom: 18px;
        }

        .piq-account-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #3a4155;
            margin-bottom: 4px;
        }

        .piq-account-value {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #e8eaf0;
        }

        .piq-account-value.role {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #c8f135;
            background: rgba(200,241,53,0.08);
            border: 1px solid rgba(200,241,53,0.2);
            border-radius: 4px;
            padding: 4px 10px;
        }

        .piq-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin: 24px 0;
        }

        @media (max-width: 900px) {
            .piq-workspace { padding: 24px 16px 60px; }
            .piq-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 480px) {
            .piq-card { padding: 24px 20px; }
        }
    </style>

    <div class="piq-workspace">
        <div class="piq-grid">

            <!-- Main card -->
            <div class="piq-card piq-card-main" data-role="{{ auth()->user()->role ?? 'student' }}">
                <div class="piq-role-tag">{{ ucfirst(auth()->user()->role ?? 'student') }}</div>

                <h3 class="piq-welcome">
                    Welcome back,<br><span>{{ auth()->user()->name }}</span>
                </h3>

                <p class="piq-desc">
                    Use your role workspace to continue exams, manage assessments, or monitor platform activity.
                </p>

                <div class="piq-actions">
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="piq-btn piq-btn-primary">
                            Admin Dashboard
                        </a>
                    @elseif (auth()->user()->role === 'teacher')
                        <a href="{{ route('teacher.exams.index') }}" class="piq-btn piq-btn-primary">
                            Manage Exams
                        </a>
                        <a href="{{ route('teacher.exams.create') }}" class="piq-btn piq-btn-secondary">
                            Create Exam
                        </a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="piq-btn piq-btn-primary">
                            My Dashboard
                        </a>
                        <a href="{{ route('leaderboard') }}" class="piq-btn piq-btn-secondary">
                            Leaderboard
                        </a>
                    @endif
                </div>
            </div>

            <!-- Account card -->
            <div class="piq-card">
                <div class="piq-account-title">Account</div>

                <div class="piq-account-row">
                    <div class="piq-account-label">Name</div>
                    <div class="piq-account-value">{{ auth()->user()->name }}</div>
                </div>

                <div class="piq-account-row">
                    <div class="piq-account-label">Email</div>
                    <div class="piq-account-value" style="font-size:13px; color:#7a8099; font-family:'JetBrains Mono',monospace; letter-spacing:0.03em;">
                        {{ auth()->user()->email }}
                    </div>
                </div>

                <div class="piq-account-row">
                    <div class="piq-account-label">Role</div>
                    <div>
                        <span class="piq-account-value role">
                            {{ ucfirst(auth()->user()->role ?? 'student') }}
                        </span>
                    </div>
                </div>

                <hr class="piq-divider">

                <a href="{{ route('profile.edit') }}" class="piq-btn piq-btn-secondary" style="width:100%; justify-content:center;">
                    Edit Profile
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
