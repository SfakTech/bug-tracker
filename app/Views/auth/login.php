<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Tracker</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="auth-page">

    <div class="auth-wrap">

        <!-- Logo -->
        <div class="auth-logo">
            <div class="auth-logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m8 2 1.88 1.88"/>
                    <path d="M14.12 3.88 16 2"/>
                    <path d="M9 7.13v-1a3.003 3.003 0 1 1 6 0v1"/>
                    <path d="M12 20c-3.3 0-6-2.7-6-6v-3a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v3c0 3.3-2.7 6-6 6"/>
                    <path d="M12 20v-9"/>
                    <path d="M6.53 9C4.6 8.8 3 7.1 3 5"/>
                    <path d="M6 13H2"/>
                    <path d="M3 21c0-2.1 1.7-3.9 3.8-4"/>
                    <path d="M20.97 5c0 2.1-1.6 3.8-3.5 4"/>
                    <path d="M22 13h-4"/>
                    <path d="M17.2 17c2.1.1 3.8 1.9 3.8 4"/>
                </svg>
            </div>
            <span class="auth-logo-text">Bug Tracker</span>
        </div>

        <!-- Card -->
        <div class="auth-card">

            <?php if (isset($_SESSION['error'])): ?>
                <div class="auth-flash error"><?= htmlspecialchars($_SESSION['error']) ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="auth-flash success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Tabs -->
            <div class="auth-tabs">
                <button type="button" id="tabLogin" class="auth-tab active" onclick="switchTab('login')">Login</button>
                <button type="button" id="tabRegister" class="auth-tab" onclick="switchTab('register')">Sign Up</button>
            </div>

            <!-- Login Form -->
            <div id="loginForm">
                <p class="form-title">Welcome back</p>
                <form method="POST" action="/login">
                    <?= CSRF::field() ?>
                    <input type="email" name="email" placeholder="Email address" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign in</button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="registerForm" style="display:none">
                <p class="form-title">Create account</p>
                <form method="POST" action="/register">
                    <?= CSRF::field() ?>
                    <input type="text" name="name" placeholder="Full name" required>
                    <input type="email" name="email" placeholder="Email address" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Create account</button>
                </form>
            </div>

        </div>

    </div>

    <script src="/assets/js/script.js"></script>
</body>
</html>
