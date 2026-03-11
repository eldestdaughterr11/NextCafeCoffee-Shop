<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/menu.css') ?>">
    <style>
        /* "MyShop" Reference Aesthetic */
        :root {
            --myshop-blue: #007bff;
            --myshop-border: #e0e0e0;
            --myshop-text: #333;
        }

        .menu-layout {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
            align-items: flex-start;
        }

        .category-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid var(--myshop-border);
            border-radius: 4px;
            padding: 0;
            box-shadow: none;
        }

        .category-sidebar h2 {
            padding: 1.2rem 1rem;
            font-size: 1.4rem;
            color: var(--myshop-text);
            margin: 0;
            font-weight: 500;
        }

        .category-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .category-item-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: #555;
            text-decoration: none;
            border-top: 1px solid var(--myshop-border);
            transition: all 0.2s;
            font-size: 1.1rem;
        }

        .category-item-link:hover {
            background: #f9f9f9;
            color: var(--myshop-blue);
        }

        .category-item-link.active {
            color: var(--myshop-blue);
            background: #fff;
        }

        .category-icon {
            margin-right: 12px;
            font-size: 1rem;
            color: #555;
            display: flex;
            align-items: center;
        }

        .menu-main-content {
            flex: 1;
        }

        /* MyShop Product Cards */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            overflow: hidden;
            border: 1px solid var(--myshop-border);
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .product-image {
            height: 180px;
            background: #fdfdfd;
            border-bottom: 1px solid var(--myshop-border);
        }

        .product-image img {
            padding: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 1.2rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .product-info h3 {
            font-size: 1.4rem;
            color: var(--myshop-text);
            margin: 0;
            font-weight: 400;
        }

        .product-price {
            font-size: 1.2rem;
            color: #666;
            font-weight: 400;
        }

        .btn-view {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.1rem;
            width: fit-content;
            margin-top: 0.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.2s;
        }

        .btn-view:hover {
            background: var(--accent-dark);
            color: white;
        }

        /* Override Welcome Banner for MyShop style */
        .welcome-banner {
            display: none; /* Reference image doesn't show a banner */
        }

        @media (max-width: 991px) {
            .menu-layout {
                flex-direction: column;
            }
            .category-sidebar {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Main Navigation Sidebar (Kept for integration) -->
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
            <a href="<?= base_url('customer/menu') ?>" class="nav-link active">
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

            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link" style="background: rgba(212, 165, 116, 0.1); border-left: 3px solid #d4a574; margin-top: 1rem;">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    </span>
                    Admin Dashboard
                </a>
            <?php endif; ?>
            
            <a href="<?= base_url('customer/profile') ?>" class="nav-link">
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

    <!-- Main Content Wrapper -->
    <div class="main-wrapper" style="background: #ffffff !important; background-color: #ffffff !important; color: #333;">
        <div class="header-top">
            <div style="display: flex; align-items: center;">
                <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </div>
                <h1 style="color: #333 !important;">Our Menu</h1>
            </div>
            <a href="<?= base_url('customer/profile') ?>" title="My Profile" style="text-decoration: none;"><div class="user-avatar"><?= strtoupper(substr(session()->get('username') ?? 'G', 0, 1)) ?></div></a>
        </div>

        <div class="menu-container">
            <!-- Welcome Banner (Coffee Themed) -->
            <div class="welcome-banner" style="display: block; background: linear-gradient(135deg, var(--side-bg) 0%, var(--accent) 100%); color: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem;">
                <h2 style="color: white; margin-bottom: 0.5rem;">Welcome, <?= esc($username) ?>! ☕</h2>
                <p style="color: rgba(255,255,255,0.8);">Discover your perfect cup of coffee and delicious treats</p>
            </div>

            <div class="menu-layout">
                <!-- Category Sidebar - Clean Style -->
                <aside class="category-sidebar">
                    <h2>Coffee Types</h2>
                    <ul class="category-list">
                        <li>
                            <a href="<?= site_url('customer/menu?category=all' . (!empty($search) ? '&search='.urlencode($search) : '') . (!empty($sort) ? '&sort='.$sort : '')) ?>"
                                class="category-item-link <?= ($selected_category === 'all') ? 'active' : '' ?>">
                                <span class="category-icon">📋</span> All Items
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                            <?php 
                                $categoryName = strtolower($cat->name);
                                $icon = '🏷️';
                                if (strpos($categoryName, 'espresso') !== false) $icon = '☕';
                                if (strpos($categoryName, 'milk') !== false || strpos($categoryName, 'latte') !== false) $icon = '🥛';
                                if (strpos($categoryName, 'cold') !== false || strpos($categoryName, 'brew') !== false) $icon = '🥤';
                                if (strpos($categoryName, 'pastr') !== false || strpos($categoryName, 'food') !== false) $icon = '🍰';
                            ?>
                            <li>
                                <a href="<?= site_url('customer/menu?category=' . urlencode($cat->name) . (!empty($search) ? '&search='.urlencode($search) : '') . (!empty($sort) ? '&sort='.$sort : '')) ?>"
                                    class="category-item-link <?= ($selected_category === $cat->name) ? 'active' : '' ?>">
                                    <span class="category-icon"><?= $icon ?></span> <?= esc(ucfirst($cat->name)) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>

                <!-- Products Grid - MyShop Style -->
                <main class="menu-main-content">
                    <div class="menu-filters" style="display: flex; gap: 1rem; margin-bottom: 2rem; align-items: center; background: #fff; padding: 1.2rem; border-radius: 8px; border: 1px solid var(--myshop-border);">
                        <form action="<?= site_url('customer/menu') ?>" method="GET" style="display: flex; gap: 0.5rem; flex: 1;">
                            <input type="hidden" name="category" value="<?= esc($selected_category) ?>">
                            <input type="hidden" name="sort" value="<?= esc($sort) ?>">
                            <input type="text" name="search" placeholder="Search coffee name..." value="<?= esc($search) ?>" 
                                   style="flex: 1; padding: 0.8rem 1rem; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                            <button type="submit" class="btn-view" style="margin-top: 0; padding: 0.8rem 1.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                SEARCH
                            </button>
                        </form>

                        <div class="sort-wrapper" style="display: flex; align-items: center; gap: 0.5rem;">
                            <label style="font-weight: 500; font-size: 0.9rem; color: #666;">Sort by:</label>
                            <select onchange="window.location.href=this.value" style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; background: white; cursor: pointer;">
                                <option value="<?= site_url('customer/menu?category='.urlencode($selected_category).(!empty($search) ? '&search='.urlencode($search) : '').'&sort=newest') ?>" <?= ($sort === 'newest' || empty($sort)) ? 'selected' : '' ?>>Newest</option>
                                <option value="<?= site_url('customer/menu?category='.urlencode($selected_category).(!empty($search) ? '&search='.urlencode($search) : '').'&sort=price_asc') ?>" <?= ($sort === 'price_asc') ? 'selected' : '' ?>>Price: Low to High</option>
                                <option value="<?= site_url('customer/menu?category='.urlencode($selected_category).(!empty($search) ? '&search='.urlencode($search) : '').'&sort=price_desc') ?>" <?= ($sort === 'price_desc') ? 'selected' : '' ?>>Price: High to Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="products-grid">
                        <?php if (empty($products)): ?>
                            <div class="empty-menu">
                                <h2>No coffee products available right now.</h2>
                            </div>
                        <?php else: ?>
                            <?php
                            $defaultImages = [
                                'Espresso' => 'images/espresso.jpg',
                                'Cappuccino' => 'images/cappuccino.jpg',
                                'Iced Americano' => 'images/iced_americano.png',
                                'Caramel Latte' => 'images/caramel_latte.png',
                                'Blueberry Muffin' => 'images/blueberrymuffin.jpg'
                            ];
                            ?>
                            <?php foreach ($products as $product): ?>
                                <div class="product-card">
                                    <div class="product-image">
                                        <?php
                                        $imagePath = !empty($product->image_url)
                                            ? $product->image_url
                                            : ($defaultImages[$product->product_name] ?? 'images/default.png');
                                        ?>
                                        <img src="<?= base_url($imagePath) ?>" alt="<?= esc($product->product_name) ?>">
                                    </div>

                                    <div class="product-info">
                                        <h3><?= esc($product->product_name) ?></h3>
                                        <span class="product-price">₱<?= number_format($product->price, 2) ?></span>
                                        <a href="<?= site_url('customer/product/' . $product->slug) ?>" class="btn-view">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            View Detail
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <?php if (session()->getFlashdata('cart_message')): ?>
        <div id="toast" class="toast-message show">
            <?= session()->getFlashdata('cart_message') ?>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('toast').classList.remove('show');
            }, 3000);
        </script>
    <?php endif; ?>

    <script>
        function increaseQty(btn) {
            const input = btn.parentElement.querySelector('.qty-input');
            let value = parseInt(input.value);
            if (value < 99) input.value = value + 1;
        }

        function decreaseQty(btn) {
            const input = btn.parentElement.querySelector('.qty-input');
            let value = parseInt(input.value);
            if (value > 1) input.value = value - 1;
        }
    </script>
    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>

</html>
