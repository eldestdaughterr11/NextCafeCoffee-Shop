<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
</head>

<body>
    <div class="auth-wrapper">
        <!-- Left Side: Coffee Photography -->
        <div class="side-panel">
            <div class="welcome-text">
                <img src="<?= base_url('images/logo.png') ?>" alt="NextCafe" style="max-width: 180px; margin-bottom: 2rem; filter: brightness(0) invert(1);">
                <h1>Welcome to website</h1>
                <p>NextCafe brings you the finest beans and crafting every cup with passion. Login to explore our premium collection.</p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="form-panel">
            <h2>USER LOGIN</h2>

            <?php if (session()->getFlashdata('msg')): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px; background: #fff5f5; color: #e53e3e; padding: 1rem; border-radius: 8px; border: 1px solid #fed7d7;">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px; background: #fff5f5; color: #e53e3e; padding: 1rem; border-radius: 8px; border: 1px solid #fed7d7;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST" class="login-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <span class="icon-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </span>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="form-group">
                    <span class="icon-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        <span>Remember</span>
                    </label>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="btn-login">LOGIN</button>

                <div class="register-link">
                    <p>Don't have account? <a href="<?= base_url('register') ?>">Register Now</a></p>
                    <p style="margin-top: 10px; font-size: 0.8rem; opacity: 0.7;">Admin access? <a href="<?= base_url('admin/login') ?>">Login here</a></p>
                </div>
            </form>
            
            <a href="<?= base_url('/') ?>" class="back-home">← Back to Home</a>
        </div>
    </div>

    <?php if (isset($login_success) && $login_success): ?>
        <div id="loginSuccessModal" class="modal-overlay" style="display: flex;">
            <div class="modal-card active">
                <div class="modal-icon">✅</div>
                <h3>Login Successful!</h3>
                <p>Welcome back, <?= esc($user_name) ?>. Redirecting you to your dashboard...</p>
                <div style="margin-top: 2rem;">
                    <div class="loader" style="margin: 0 auto;"></div>
                </div>
            </div>
        </div>
        <style>
            .loader {
                width: 30px;
                height: 30px;
                border: 3px solid #f3f3f3;
                border-top: 3px solid #422c1d;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
            
            .modal-overlay {
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px);
                display: flex; align-items: center; justify-content: center; z-index: 9999;
            }
            .modal-card {
                background: white; padding: 2.5rem; border-radius: 20px; text-align: center;
                max-width: 400px; width: 90%; box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            }
            .modal-icon { font-size: 3rem; margin-bottom: 1rem; }
            .modal-card h3 { font-family: 'Playfair Display', serif; color: #422c1d; font-size: 1.5rem; margin-bottom: 0.8rem; }
            .modal-card p { color: #666; margin-bottom: 2rem; font-size: 0.95rem; }
        </style>
        <script>
            setTimeout(function() {
                window.location.href = '<?= site_url($redirect_url) ?>';
            }, 2000);
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div id="auth-toast" style="position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 1rem 2rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); z-index: 2000; animation: slideIn 0.5s ease-out;">
            <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.2rem;">✨</span>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem;">Success</div>
                    <div style="font-size: 0.85rem; opacity: 0.9;"><?= session()->getFlashdata('success') ?></div>
                </div>
            </div>
        </div>
        <style>
            @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        </style>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('auth-toast');
                if (toast) {
                    toast.style.transition = '0.5s';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 4000);
        </script>
    <?php endif; ?>
</body>
</html>

