<?php
$flash = get_flash();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PG Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #14b8a6;
            --success-color: #16a34a;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --background-color: #f5f7ff;
            --surface-color: #ffffff;
            --card-color: #ffffff;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: rgba(15, 23, 42, 0.08);
            --shadow-sm: 0 8px 24px rgba(79, 70, 229, 0.08);
            --shadow-md: 0 20px 45px rgba(15, 23, 42, 0.12);
            --radius-lg: 28px;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            color: var(--text-primary);
        }
        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 30px;
        }
        .auth-card {
            width: min(1200px, 100%);
            min-height: 760px;
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.7);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            display: grid;
            grid-template-columns: 1.12fr 0.88fr;
        }
        .auth-visual {
            position: relative;
            padding: 50px 52px;
            background:
                linear-gradient(135deg, rgba(32, 40, 88, 0.75), rgba(79, 70, 229, 0.55)),
                url('https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 10px 16px;
            border-radius: 999px;
            width: fit-content;
        }
        .hero-copy h1 {
            font-size: clamp(2.2rem, 3vw, 4rem);
            line-height: 1.1;
            font-weight: 800;
            max-width: 430px;
        }
        .hero-copy p {
            max-width: 420px;
            font-size: 1.06rem;
            line-height: 1.8;
            color: rgba(255,255,255,0.8);
        }
        .feature-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }
        .feature-pill {
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.12);
            font-size: 0.85rem;
            color: white;
        }
        .auth-form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 42px 38px;
            background: rgba(255,255,255,0.9);
        }
        .auth-form {
            width: min(100%, 440px);
        }
        .eyebrow {
            color: var(--primary-color);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }
        h2 {
            font-size: clamp(2rem, 2.4vw, 2.6rem);
            font-weight: 800;
            margin: 10px 0 8px;
        }
        .subheading {
            color: var(--text-secondary);
            margin-bottom: 28px;
        }
        .floating-field {
            position: relative;
            margin-bottom: 20px;
        }
        .floating-field i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.05rem;
        }
        .floating-field input {
            width: 100%;
            border: 1px solid var(--border-color);
            background: rgba(255,255,255,0.7);
            border-radius: 16px;
            padding: 18px 18px 18px 46px;
            font-size: 1rem;
            outline: none;
            transition: all 0.2s ease;
            box-shadow: none;
        }
        .floating-field input:focus {
            border-color: rgba(79, 70, 229, 0.55);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }
        .password-wrap {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 1.1rem;
        }
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 14px 0 22px;
            font-size: 0.92rem;
            color: var(--text-secondary);
        }
        .custom-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .custom-check input {
            accent-color: var(--primary-color);
        }
        .btn-primary-custom {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 16px;
            padding: 16px 22px;
            font-weight: 700;
            letter-spacing: 0.02em;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(79, 70, 229, 0.18);
        }
        .btn-loading {
            pointer-events: none;
        }
        .helper-links {
            margin-top: 14px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.92rem;
        }
        .helper-links a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }
        .alert-box {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 0.94rem;
            border: 1px solid transparent;
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.08);
            color: #b91c1c;
            border-color: rgba(239, 68, 68, 0.2);
        }
        .alert-success {
            background: rgba(22, 163, 74, 0.09);
            color: #166534;
            border-color: rgba(22, 163, 74, 0.2);
        }
        @media (max-width: 900px) {
            .auth-card {
                grid-template-columns: 1fr;
            }
            .auth-visual {
                min-height: 320px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card">
            <section class="auth-visual">
                <div class="brand-badge"><i class="bi bi-house-door-fill"></i> StayNest</div>
                <div class="hero-copy">
                    <h1>Find your perfect place to stay.</h1>
                    <p>Smart accommodation discovery for students and professionals. Discover verified PGs, compare amenities, and book faster.</p>
                    <div class="feature-list">
                        <span class="feature-pill">Verified PGs</span>
                        <span class="feature-pill">Fast approvals</span>
                        <span class="feature-pill">Smart matching</span>
                    </div>
                </div>
                <div></div>
            </section>
            <section class="auth-form-panel">
                <form class="auth-form" method="POST" action="/login">
                    <?= csrf_field(); ?>
                    <?php if ($flash): ?>
                        <div class="alert-box alert-<?= $flash['type'] === 'success' ? 'success' : 'error'; ?>"><?= e($flash['message']) ?></div>
                    <?php endif; ?>
                    <div class="eyebrow">Welcome back</div>
                    <h2>Sign in to continue</h2>
                    <p class="subheading">Access your dashboard and manage accommodation with confidence.</p>

                    <div class="floating-field">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" placeholder="Email address" required value="admin@example.com">
                    </div>

                    <div class="floating-field password-wrap">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="passwordInput" name="password" placeholder="Password" required value="Admin@123">
                        <button type="button" class="toggle-password" aria-label="Toggle password visibility"><i class="bi bi-eye-slash"></i></button>
                    </div>

                    <div class="remember-row">
                        <label class="custom-check"><input type="checkbox" name="remember" value="1"> Remember me</label>
                        <a href="mailto:admin@example.com?subject=Password%20reset" style="color: var(--primary-color); text-decoration:none; font-weight:600;">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary-custom" id="loginBtn">
                        <span class="btn-label"><i class="bi bi-box-arrow-in-right me-2"></i>Login</span>
                    </button>

                    <div class="helper-links">
                        Need access? <a href="mailto:admin@example.com">Contact admin</a>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggle = document.querySelector('.toggle-password');
        const input = document.getElementById('passwordInput');
        toggle.addEventListener('click', function() {
            const visible = input.type === 'text';
            input.type = visible ? 'password' : 'text';
            toggle.innerHTML = visible ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });

        document.querySelector('.auth-form').addEventListener('submit', function() {
            const button = document.getElementById('loginBtn');
            if (button.dataset.submitting === 'true') return;
            button.dataset.submitting = 'true';
            button.classList.add('btn-loading');
            button.disabled = true;
            button.querySelector('.btn-label').innerHTML = '<span class="me-2"><i class="bi bi-arrow-repeat"></i></span>Signing in...';
        });
    </script>
</body>
</html>
