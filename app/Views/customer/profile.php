<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <style>
        .profile-wrapper {
            max-width: 700px;
            margin: 2rem auto;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--side-bg, #3d2314) 0%, var(--accent, #d4a574) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
        }

        .profile-avatar-large {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            border: 3px solid rgba(255,255,255,0.5);
        }

        .profile-header h2 {
            color: white;
            margin: 0 0 0.25rem 0;
            font-size: 1.5rem;
        }

        .profile-header p {
            color: rgba(255,255,255,0.75);
            margin: 0;
            font-size: 0.9rem;
        }

        .profile-body {
            padding: 2rem;
        }

        .form-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--accent, #d4a574);
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            margin-bottom: 1.2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #555;
        }

        .form-group input {
            padding: 0.75rem 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
            outline: none;
            width: 100%;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: var(--accent, #d4a574);
        }

        .form-group input:disabled {
            background: #f8f8f8;
            color: #999;
            cursor: not-allowed;
        }

        .alert-error {
            background: #fdecea;
            border: 1px solid #f5c6cb;
            color: #c0392b;
            padding: 0.9rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #eafaf1;
            border: 1px solid #a9dfbf;
            color: #27ae60;
            padding: 0.9rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--accent, #d4a574), var(--accent-dark, #b8854a));
            color: white;
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 1.5rem;
            transition: opacity 0.2s;
        }

        .btn-save:hover {
            opacity: 0.9;
        }

        .hint-text {
            font-size: 0.78rem;
            color: #aaa;
            margin-top: 0.2rem;
        }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="<?= base_url('images/logo.png') ?>" alt="NextCafe" class="brand-logo">
        </div>
        <nav class="sidebar-nav">
            <a href="<?= base_url('customer/dashboard') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </span>
                Dashboard
            </a>
            <a href="<?= base_url('customer/menu') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Menu
            </a>
            <a href="<?= base_url('customer/orders') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </span>
                My Orders
            </a>
            <a href="<?= base_url('customer/cart') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </span>
                Shopping Cart
            </a>
            <a href="<?= base_url('customer/profile') ?>" class="nav-link active">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </span>
                My Profile
            </a>
            <a href="javascript:void(0)" onclick="confirmLogout('<?= base_url('customer/logout') ?>')" class="nav-link" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </span>
                Logout
            </a>
        </nav>
    </div>

    <div class="main-wrapper">
        <div class="header-top">
            <div style="display: flex; align-items: center;">
                <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </div>
                <h1>My Profile</h1>
            </div>
            <div class="user-avatar"><?= strtoupper(substr($user->username ?? 'G', 0, 1)) ?></div>
        </div>

        <div class="profile-wrapper">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar-large">
                        <?= strtoupper(substr($user->name ?? $user->username ?? 'U', 0, 1)) ?>
                    </div>
                    <h2><?= esc($user->name ?? $user->username) ?></h2>
                    <p><?= esc($user->email) ?></p>
                </div>

                <div class="profile-body">
                    <?php if (session()->getFlashdata('profile_success')): ?>
                        <div class="alert-success">✓ <?= session()->getFlashdata('profile_success') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('profile_error')): ?>
                        <div class="alert-error">✕ <?= session()->getFlashdata('profile_error') ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('customer/profile/update') ?>" method="POST">
                        <div class="form-section-title">Personal Information</div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label>Full Name</label>
                                <input type="text" name="name" value="<?= esc($user->name ?? '') ?>" placeholder="Enter your full name">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" value="<?= esc($user->username) ?>" placeholder="Your username">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?= esc($user->email) ?>" placeholder="Your email address">
                            </div>
                        </div>

                        <div class="form-section-title" style="margin-top: 2rem;">Change Password</div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label>Current Password</label>
                                <input type="password" name="current_password" placeholder="Enter current password to confirm changes">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" placeholder="Leave blank to keep current">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="confirm_password" placeholder="Repeat new password">
                            </div>
                        </div>
                        <p class="hint-text">You must enter your current password to save any changes.</p>

                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>

</html>
