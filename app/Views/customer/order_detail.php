<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order->id ?> - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <style>
        .detail-container { max-width: 800px; margin: 2rem auto; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .order-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 1rem; margin-bottom: 2rem; }
        .order-info { margin-bottom: 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .info-block h3 { font-size: 0.9rem; color: #888; text-transform: uppercase; margin-bottom: 0.5rem; }
        .info-block p { font-size: 1.1rem; color: #333; font-weight: 600; }
        .item-list { border: 1px solid #eee; border-radius: 8px; overflow: hidden; }
        .item-row { display: flex; align-items: center; padding: 1rem; border-bottom: 1px solid #eee; }
        .item-image { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 1rem; }
        .item-details { flex: 1; }
        .item-price { font-weight: 600; }
        .order-total-block { margin-top: 2rem; text-align: right; border-top: 2px solid #eee; padding-top: 1rem; }
        .total-amount { font-size: 1.5rem; color: #6F4E37; font-weight: 700; }
    </style>
</head>
<body style="background: #f8f9fa;">
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="<?= base_url('images/logo.png') ?>" alt="NextCafe" class="brand-logo">
        </div>
        <nav class="sidebar-nav">
            <a href="<?= base_url('customer/dashboard') ?>" class="nav-link">Dashboard</a>
            <a href="<?= base_url('customer/menu') ?>" class="nav-link">Menu</a>
            <a href="<?= base_url('customer/orders') ?>" class="nav-link active">My Orders</a>
            <a href="<?= base_url('customer/cart') ?>" class="nav-link">Shopping Cart</a>
            <a href="<?= base_url('customer/about') ?>" class="nav-link">About Us</a>
            <a href="<?= base_url('customer/contact') ?>" class="nav-link">Contact Us</a>
            
            <a href="javascript:void(0)" onclick="confirmLogout('<?= base_url('customer/logout') ?>')" class="nav-link" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">Logout</a>
        </nav>
    </div>

    <div class="main-wrapper">
        <div class="detail-container">
            <div class="order-header">
                <div>
                    <h1 style="font-size: 1.8rem;">Order #<?= $order->id ?></h1>
                    <p style="color: #666;"><?= date('F j, Y \a\t g:i a', strtotime($order->created_at)) ?></p>
                </div>
                <div class="status-badge status-<?= strtolower($order->status) ?>" style="padding: 8px 20px; border-radius: 20px; background: #e8f5e9; color: #2e7d32; font-weight: 600;">
                    <?= ucfirst($order->status) ?>
                </div>
            </div>

            <div class="order-info">
                <div class="info-block">
                    <h3>Pickup/Delivery Method</h3>
                    <p><?= esc($order->shipping_method) ?></p>
                </div>
                <div class="info-block">
                    <h3>Payment Method</h3>
                    <p><?= esc($order->payment_method) ?></p>
                </div>
                <div class="info-block" style="grid-column: span 2;">
                    <h3>Delivery Address</h3>
                    <p><?= esc($order->address ?: 'N/A') ?></p>
                </div>
                <?php if ($order->checkin_time): ?>
                    <div class="info-block">
                        <h3>Check-in Time</h3>
                        <p><?= date('F j, Y \a\t g:i a', strtotime($order->checkin_time)) ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($order->checkout_time): ?>
                    <div class="info-block">
                        <h3>Check-out Time</h3>
                        <p><?= date('F j, Y \a\t g:i a', strtotime($order->checkout_time)) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <h2>Order Items</h2>
            <div class="item-list">
                <?php foreach ($items as $item): ?>
                    <div class="item-row">
                        <img src="<?= base_url($item->image_url ?: 'images/default.jpg') ?>" class="item-image">
                        <div class="item-details">
                            <h4 style="margin: 0;"><?= esc($item->product_name) ?></h4>
                            <p style="margin: 0.2rem 0; color: #666;">Quantity: <?= $item->quantity ?></p>
                        </div>
                        <div class="item-price">
                            ₱<?= number_format($item->price * $item->quantity, 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="order-total-block">
                <p style="margin-bottom: 0.5rem; color: #666;">Grand Total</p>
                <div class="total-amount">₱<?= number_format($order->total_amount, 2) ?></div>
            </div>

            <div style="margin-top: 2rem; text-align: center;">
                <a href="<?= site_url('customer/orders') ?>" style="color: #666; text-decoration: none;">&larr; Back to Orders</a>
            </div>
        </div>
    </div>
    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>
