<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/wishlist.css') ?>">
</head>

<body>
    <!-- Sidebar Navigation -->
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
            <a href="<?= base_url('customer/wishlist') ?>" class="nav-link active">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                </span>
                Wishlist
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
        <div class="header-top">
            <div style="display: flex; align-items: center;">
                <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </div>
                <h1>My Wishlist</h1>
            </div>
            <div class="user-avatar"><?= strtoupper(substr(session()->get('username') ?? 'G', 0, 1)) ?></div>
        </div>

        <div class="wishlist-container">
            <?php if (empty($wishlistItems)): ?>
                <div class="empty-wishlist">
                    <div class="empty-wishlist-icon">❤️</div>
                    <h2>Your Wishlist is Empty</h2>
                    <p>Start adding your favorite coffee products to your wishlist!</p>
                    <a href="<?= site_url('customer/menu') ?>" class="btn-browse">Browse Menu</a>
                </div>
            <?php else: ?>
                <div class="wishlist-grid">
                    <?php
                    $defaultImages = [
                        'Espresso' => 'images/espresso.jpg',
                        'Cappuccino' => 'images/cappuccino.jpg',
                        'Iced Americano' => 'images/iced_americano.png',
                        'Caramel Latte' => 'images/caramel_latte.png',
                        'Blueberry Muffin' => 'images/blueberrymuffin.jpg'
                    ];
                    ?>
                    <?php foreach ($wishlistItems as $item): ?>
                        <div class="wishlist-card">
                            <div class="wishlist-image">
                                <?php
                                $imagePath = !empty($item->image_url)
                                    ? $item->image_url
                                    : ($defaultImages[$item->product_name] ?? 'images/default.png');
                                ?>
                                <img src="<?= base_url($imagePath) ?>" alt="<?= esc($item->product_name) ?>">
                                <?php if ($item->status === 'available'): ?>
                                    <span class="product-status-badge">Available</span>
                                <?php else: ?>
                                    <span class="product-status-badge" style="background: #dc3545;">Unavailable</span>
                                <?php endif; ?>
                            </div>

                            <div class="wishlist-info">
                                <h3><?= esc($item->product_name) ?></h3>
                                <div class="wishlist-category"><?= esc($item->category) ?></div>
                                
                                <div class="wishlist-rating">
                                    <span class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= floor($item->averageRating)): ?>
                                                ★
                                            <?php else: ?>
                                                ☆
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </span>
                                    <?php if ($item->reviewCount > 0): ?>
                                        <span>(<?= $item->reviewCount ?>)</span>
                                    <?php endif; ?>
                                </div>

                                <div class="wishlist-price">₱<?= number_format($item->price, 2) ?></div>

                                <div class="wishlist-actions">
                                    <a href="<?= site_url('customer/product/' . $item->slug) ?>" class="btn-add-cart">View Details</a>
                                    <form action="<?= site_url('customer/wishlist/remove') ?>" method="POST" style="flex: 1;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= $item->product_id ?>">
                                        <button type="submit" class="btn-remove">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Toast Messages -->
    <?php if (session()->getFlashdata('wishlist_message')): ?>
        <div id="toast" class="toast-message show">
            <?= session()->getFlashdata('wishlist_message') ?>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('toast').classList.remove('show');
            }, 3000);
        </script>
    <?php endif; ?>

    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>

</html>
