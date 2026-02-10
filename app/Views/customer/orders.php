<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/menu.css') ?>">
    <style>
        .orders-container {
            padding: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }
        .orders-table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            overflow: hidden;
            margin-top: 2rem;
        }
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .orders-table th {
            background: #f8f9fa;
            padding: 1.2rem;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #eee;
        }
        .orders-table td {
            padding: 1.2rem;
            border-bottom: 1px solid #eee;
            color: #555;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: capitalize;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        .empty-orders {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            border: 1px dashed #ccc;
            margin-top: 2rem;
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
            <a href="<?= base_url('customer/orders') ?>" class="nav-link active">
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

    <div class="main-wrapper" style="background: #ffffff !important; min-height: 100vh;">
        <div class="header-top">
            <div style="display: flex; align-items: center;">
                <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </div>
                <h1 style="color: #333;">My Order History</h1>
            </div>
            <div class="user-avatar"><?= strtoupper(substr(session()->get('username') ?? 'G', 0, 1)) ?></div>
        </div>

        <div class="orders-container">
            <?php if (empty($orders)): ?>
                <div class="empty-orders">
                    <h2 style="color: #333; margin-bottom: 1rem;">No orders yet</h2>
                    <p style="color: #666; margin-bottom: 2rem;">You haven't placed any orders with us yet. Ready for some coffee?</p>
                    <a href="<?= site_url('customer/menu') ?>" class="btn-view" style="text-decoration: none;">Go to Menu</a>
                </div>
            <?php else: ?>
                <div class="orders-table-card">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?= esc($order->id) ?></td>
                                    <td><?= date('M d, Y', strtotime($order->created_at)) ?></td>
                                    <td>₱<?= number_format($order->total_amount, 2) ?></td>
                                    <td>
                                        <?php 
                                            $statusClass = 'status-' . strtolower($order->status);
                                        ?>
                                        <span class="status-badge <?= $statusClass ?>">
                                            <?= esc($order->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('customer/order/' . $order->id) ?>" class="btn-view" style="padding: 6px 12px; font-size: 0.9rem; text-decoration: none;">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>
