<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="<?= base_url('images/logo.png') ?>" alt="NextCafe" class="brand-logo">
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= base_url('customer/dashboard') ?>" class="nav-link active">
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
            <a href="<?= base_url('customer/about') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                About Us
            </a>
            <a href="<?= base_url('customer/contact') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </span>
                Contact Us
            </a>
            
            <a href="javascript:void(0)" onclick="confirmLogout('<?= base_url('customer/logout') ?>')" class="nav-link" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </span>
                Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <div class="header-top fade-in">
            <div style="display: flex; align-items: center;">
                <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </div>
                <div>
                    <span style="font-size: 0.9rem; color: #888;">Good morning,</span>
                    <h1 style="margin: 0;">Martin Ore</h1>
                </div>
            </div>
            <div class="user-avatar"><?= strtoupper(substr(session()->get('username'), 0, 1)) ?></div>
        </div>

        <div class="hero-banner fade-in delay-1">
            <div class="hero-content">
                <h2>Fresh Coffee, <br>Delivered to You.</h2>
                <p>Start your day with our premium selection of beans and pastries.</p>
                <a href="<?= base_url('customer/menu') ?>" class="btn-cta">Order Now</a>
            </div>
            <!-- Optional: Hero Image could go here if not background -->
        </div>

        <div class="dashboard-grid">
            <!-- Left Column: Quick Actions & Recent -->
            <div class="left-col fade-in delay-2">
                <div class="section-title">
                    <h3>Explore Menu</h3>
                </div>
                <div class="quick-categories">
                    <a href="<?= base_url('customer/menu?category=espresso') ?>" class="category-card">
                        <span class="cat-emoji">☕</span>
                        <div class="cat-name">Espresso</div>
                    </a>
                    <a href="<?= base_url('customer/menu?category=iced') ?>" class="category-card">
                        <span class="cat-emoji">🥤</span>
                        <div class="cat-name">Iced</div>
                    </a>
                    <a href="<?= base_url('customer/menu?category=pastry') ?>" class="category-card">
                        <span class="cat-emoji">🥐</span>
                        <div class="cat-name">Snacks</div>
                    </a>
                    <a href="<?= base_url('customer/menu?category=special') ?>" class="category-card">
                        <span class="cat-emoji">✨</span>
                        <div class="cat-name">Specials</div>
                    </a>
                </div>

                <div class="section-title">
                    <h3>Popular Right Now</h3>
                    <a href="<?= base_url('customer/menu') ?>" style="font-size: 0.9rem; color: var(--accent); text-decoration: none;">See All</a>
                </div>
                <div class="featured-slider">
                    <!-- Static Mock Data for Visuals (since we might not have 'popular' query yet) -->
                    <div class="featured-item">
                        <img src="<?= base_url('images/cappuccino.jpg') ?>" class="featured-img" alt="Cappuccino">
                        <div class="featured-info">
                            <h4>Cappuccino</h4>
                            <div class="featured-price">₱140.00</div>
                        </div>
                    </div>
                    <div class="featured-item">
                        <img src="<?= base_url('images/blueberrymuffin.jpg') ?>" class="featured-img" alt="Muffin">
                        <div class="featured-info">
                            <h4>Blueberry Muffin</h4>
                            <div class="featured-price">₱85.00</div>
                        </div>
                    </div>
                    <div class="featured-item">
                        <img src="<?= base_url('images/espresso.jpg') ?>" class="featured-img" alt="Espresso">
                        <div class="featured-info">
                            <h4>Espresso</h4>
                            <div class="featured-price">₱120.00</div>
                        </div>
                    </div>
                    <div class="featured-item">
                        <div style="background: #f8f8f8; width: 80px; height: 80px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">🍫</div>
                        <div class="featured-info">
                            <h4>Chocolate Cookie</h4>
                            <div class="featured-price">₱60.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Loyalty Card -->
            <div class="right-col fade-in delay-3">
                <div class="loyalty-card">
                    <div class="loyalty-header">
                        <div class="loyalty-logo">NextCafe Gold</div>
                        <div style="font-size: 1.5rem;">👑</div>
                    </div>
                    <div>
                        <div class="points-display">350</div>
                        <div class="points-label">Current Points</div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 70%;"></div>
                    </div>
                    <div class="loyalty-footer">
                        50 points to next free drink!
                    </div>
                </div>

                <!-- Wishlist Preview -->
                <div class="card" style="margin-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3>My Wishlist ❤️</h3>
                        <?php if (!empty($wishlistItems)): ?>
                            <a href="<?= base_url('customer/wishlist') ?>" style="font-size: 0.85rem; color: var(--accent); text-decoration: none;">View All (<?= $wishlistCount ?>)</a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (empty($wishlistItems)): ?>
                        <div style="text-align: center; padding: 2rem 0; color: #888;">
                            <div style="font-size: 3rem; margin-bottom: 0.5rem;">💭</div>
                            <p style="margin: 0; font-size: 0.9rem;">No items in wishlist</p>
                            <a href="<?= base_url('customer/menu') ?>" style="font-size: 0.85rem; color: var(--accent); text-decoration: none; margin-top: 0.5rem; display: inline-block;">Browse Menu</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($wishlistItems as $item): ?>
                            <div class="order-item" style="display: flex; gap: 1rem; align-items: center;">
                                <?php
                                $defaultImages = [
                                    'Espresso' => 'images/espresso.jpg',
                                    'Cappuccino' => 'images/cappuccino.jpg',
                                    'Iced Americano' => 'images/iced_americano.png',
                                    'Caramel Latte' => 'images/caramel_latte.png',
                                    'Blueberry Muffin' => 'images/blueberrymuffin.jpg'
                                ];
                                $imagePath = !empty($item->image_url) ? $item->image_url : ($defaultImages[$item->product_name] ?? 'images/default.png');
                                ?>
                                <img src="<?= base_url($imagePath) ?>" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;" alt="<?= esc($item->product_name) ?>">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 0.95rem;"><?= esc($item->product_name) ?></div>
                                    <div style="font-size: 0.85rem; color: var(--accent-dark); font-weight: 600;">₱<?= number_format($item->price, 2) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="card">
                    <h3>Recent Activity</h3>
                    <div class="order-item">
                        <div>
                            <div style="font-weight: 600;">Caramel Macchiato</div>
                            <div style="font-size: 0.85rem; color: #888;">Yesterday</div>
                        </div>
                        <span class="status-completed">Done</span>
                    </div>
                    <div class="order-item">
                        <div>
                            <div style="font-weight: 600;">Espresso</div>
                            <div style="font-size: 0.85rem; color: #888;">Nov 20</div>
                        </div>
                        <span class="status-completed">Done</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('login_success')): ?>
        <div id="login-toast" style="position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 1rem 2rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); z-index: 2000; animation: slideIn 0.5s ease-out;">
            <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.2rem;">✅</span>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem;">Success</div>
                    <div style="font-size: 0.85rem; opacity: 0.9;"><?= session()->getFlashdata('login_success') ?></div>
                </div>
            </div>
        </div>
        <style>
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        </style>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('login-toast');
                if (toast) {
                    toast.style.transition = '0.5s';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 4000);
        </script>
    <?php endif; ?>
    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>
