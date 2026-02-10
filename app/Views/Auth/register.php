<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/register.css') ?>">
</head>

<body>
    <div class="auth-wrapper">
        <!-- Left Side: Coffee Photography -->
        <div class="side-panel">
            <div class="welcome-text">
                <h1>Join the Starvan community</h1>
                <p>Register to unlock exclusive offers, track your coffee orders, and discover new premium blends curated just for you.</p>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="form-panel">
            <h2>CREATE ACCOUNT</h2>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <ul style="list-style: none; padding: 0;">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST" class="register-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <span class="icon-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </span>
                    <input type="text" id="username" name="username" placeholder="Display Name" value="<?= old('username') ?>" required>
                </div>

                <div class="form-group">
                    <span class="icon-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </span>
                    <input type="email" id="email" name="email" placeholder="Email Id" value="<?= old('email') ?>" required>
                </div>

                <div class="form-group">
                    <span class="icon-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Create Password" required>
                    <small>Minimum 6 characters</small>
                </div>

                <div class="form-group">
                    <span class="icon-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </span>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                </div>

                <label class="checkbox-container">
                    <input type="checkbox" required>
                    <span>I agree to the <a href="#">Terms & Conditions</a></span>
                </label>

                <button type="submit" class="btn-register">REGISTER</button>

                <div class="login-link">
                    <p>Already have an account? <a href="<?= base_url('login') ?>">Login Now</a></p>
                </div>
            </form>
            
            <a href="<?= base_url('/') ?>" class="back-home">← Back to Home</a>
        </div>
    </div>
</body>

</html>

