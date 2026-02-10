<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Starvan Coffee Admin</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>

<body>
    <!-- Sidebar (BrewBean Style) -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="<?= base_url('images/logo.png') ?>" alt="NextCafe" class="brand-logo">
            <div class="sidebar-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </span>
                Dashboard
            </a>
            <a href="#menu" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Menu
            </a>
            <a href="#" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Customers
            </a>
            <a href="#" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </span>
                Orders
            </a>
            <a href="#" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                </span>
                Users
            </a>

            <a href="javascript:void(0)" onclick="confirmLogout('<?= site_url('logout') ?>')" class="nav-link" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </span>
                Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Bar -->
        <div class="header-top">
            <h1>Dashboard</h1>
            <div class="user-meta">
                <span>Welcome, <?= esc($user->username) ?></span>
                <div class="user-avatar"><?= strtoupper(substr($user->username, 0, 1)) ?></div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="dashboard-stats">
            <div class="stat-item">
                <div class="stat-emoji">💰</div>
                <div class="stat-info">
                    <h3>Revenue</h3>
                    <div class="value">₱<?= number_format($total_revenue, 2) ?></div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-emoji">📦</div>
                <div class="stat-info">
                    <h3>Orders</h3>
                    <div class="value"><?= $total_orders ?></div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-emoji">👥</div>
                <div class="stat-info">
                    <h3>Customers</h3>
                    <div class="value"><?= $total_customers ?></div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-emoji">☕</div>
                <div class="stat-info">
                    <h3>Items</h3>
                    <div class="value"><?= $total_products ?></div>
                </div>
            </div>
        </div>

        <!-- Café Shop Menu Section -->
        <div class="menu-section" id="menu">
            <div class="section-header">
                <h2>Café Shop Menu</h2>
                <a href="<?= site_url('admin/products/add') ?>" class="btn-add" title="Add New Product">+</a>
            </div>

            <div class="product-grid">
                <?php
                // Standard default images for demo if missing
                $defaultImages = [
                    'Black Coffee' => 'images/espresso.jpg',
                    'Espresso' => 'images/espresso.jpg',
                    'Cappuccino' => 'images/cappuccino.jpg'
                ];
                ?>

                <?php if (empty($products)): ?>
                    <p style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #888;">No items in the menu yet.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php
                                $img = !empty($product->image_url) ? $product->image_url : ($defaultImages[$product->product_name] ?? 'images/default.jpg');
                                ?>
                                <img src="<?= base_url($img) ?>" alt="<?= esc($product->product_name) ?>">
                                
                                <div class="card-actions">
                                    <a href="<?= site_url('admin/products/edit/' . $product->id) ?>" class="action-btn btn-edit" title="Edit Product" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <a href="<?= site_url('admin/products/delete/' . $product->id) ?>" class="action-btn btn-delete" title="Delete Product" style="display: flex; align-items: center; justify-content: center; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                </div>
                            </div>

                            <div class="product-details">
                                <h3><?= esc($product->product_name) ?></h3>
                                <p><?= esc($product->description ?? 'Premium brewed coffee blend') ?></p>
                                <div class="price-tag">₱<?= number_format($product->price, 2) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Activity (Optional but good for store owners) -->
        <div class="menu-section" style="margin-top: 4rem;">
            <div class="section-header">
                <h2>Recent Orders</h2>
            </div>
            <div style="background: white; border-radius: 20px; padding: 2rem; box-shadow: var(--shadow);">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid #f8f9fa;">
                            <th style="padding: 1rem; color: #888; font-weight: 600;">OrderID</th>
                            <th style="padding: 1rem; color: #888; font-weight: 600;">Customer</th>
                            <th style="padding: 1rem; color: #888; font-weight: 600;">Date</th>
                            <th style="padding: 1rem; color: #888; font-weight: 600;">Amount</th>
                            <th style="padding: 1rem; color: #888; font-weight: 600;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recent_orders)): ?>
                            <tr><td colspan="5" style="padding: 2rem; text-align: center; color: #aaa;">No recent orders.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recent_orders as $order): ?>
                                <tr style="border-bottom: 1px solid #f8f9fa;">
                                    <td style="padding: 1rem; font-weight: 600;">#<?= $order->id ?></td>
                                    <td style="padding: 1rem;"><?= esc($order->customer_name) ?></td>
                                    <td style="padding: 1rem; color: #777;"><?= date('M j, Y', strtotime($order->created_at)) ?></td>
                                    <td style="padding: 1rem; font-weight: 600;">₱<?= number_format($order->total_amount, 2) ?></td>
                                    <td style="padding: 1rem;">
                                        <form action="<?= site_url('admin/orders/update') ?>" method="POST" style="display: flex; align-items: center;">
                                            <input type="hidden" name="order_id" value="<?= $order->id ?>">
                                            <select name="status" onchange="this.form.submit()" style="padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; border: 1px solid #ddd; background: #e8f5e9; color: #2e7d32; cursor: pointer; outline: none;">
                                                <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="completed" <?= $order->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                <option value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div style="margin-top: 4rem; text-align: center; color: #ccc; font-size: 0.8rem; letter-spacing: 1px;">
            &copy; <?= date('Y') ?> STARVAN COFFEE ADMIN SYSTEM
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
