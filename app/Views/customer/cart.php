<?php
$session = session();
$cart = $cart ?? [];
$item_count = array_sum(array_column($cart, 'quantity'));
$cart_total = 0;

foreach ($cart as $item) {
    $cart_total += $item['price'] * $item['quantity'];
}

$tax_rate = 0.12;
$tax_amount = $cart_total * $tax_rate;
$delivery_fee = $cart_total > 0 ? 50 : 0;
$grand_total = $cart_total + $tax_amount + $delivery_fee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/cart.css') ?>">
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
            <a href="<?= base_url('customer/cart') ?>" class="nav-link active">
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

    <div class="main-wrapper">
        <div class="header-top">
            <div style="display: flex; align-items: center;">
                <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </div>
                <h1 style="color: #333;">Shopping Cart</h1>
            </div>
            <div class="user-avatar"><?= strtoupper(substr(session()->get('username') ?? 'G', 0, 1)) ?></div>
        </div>

        <?php if (empty($cart)): ?>
            <div style="background: white; border-radius: 20px; padding: 4rem; text-align: center; box-shadow: var(--shadow);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                <h2 style="margin-bottom: 0.5rem;">Your cart is empty</h2>
                <p style="color: #666; margin-bottom: 2rem;">Looks like you haven't added any coffee yet.</p>
                <a href="<?= site_url('customer/menu') ?>" class="btn-checkout" style="text-decoration: none; display: inline-block; width: auto; padding: 1rem 2rem;">Browse Menu</a>
            </div>
        <?php else: ?>
            <div class="cart-content">
                <main class="cart-items-panel">
                    <div class="cart-header">
                        <h2>Cart Items (<?= $item_count ?>)</h2>
                        <form method="POST" action="<?= site_url('customer/clear_cart') ?>">
                            <button type="submit" class="btn-clear-cart" onclick="return confirm('Clear cart?')">Empty Cart</button>
                        </form>
                    </div>

                    <?php foreach ($cart as $product_id => $item): ?>
                        <div class="cart-item">
                            <img src="<?= base_url($item['image_url'] ?: 'images/default.jpg') ?>" class="item-img" alt="<?= esc($item['product_name']) ?>">
                            <div class="item-info">
                                <h3><?= esc($item['product_name']) ?></h3>
                                <p class="item-price">₱<?= number_format($item['price'], 2) ?></p>
                            </div>
                            <div class="quantity-controls">
                                <form method="POST" action="<?= site_url('customer/update_cart') ?>" style="display: flex; align-items: center;">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <button type="submit" name="action" value="decrease" class="qty-btn">-</button>
                                    <span class="qty-display"><?= $item['quantity'] ?></span>
                                    <button type="submit" name="action" value="increase" class="qty-btn">+</button>
                                </form>
                            </div>
                            <div class="item-actions">
                                <div style="font-weight: 700; color: var(--side-bg);">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                                <form method="POST" action="<?= site_url('customer/remove_from_cart') ?>">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <button type="submit" class="btn-remove">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <a href="<?= site_url('customer/menu') ?>" class="btn-continue">← Continue Shopping</a>
                </main>

                <aside class="summary-panel">
                    <h2>Order Summary</h2>
                    <form method="POST" action="<?= site_url('customer/checkout') ?>">
                        <div class="form-group">
                            <label>Shipping Method</label>
                            <select name="shipping_method" id="shipping_method" class="styled-select" onchange="updateTotals()">
                                <option value="Delivery" data-fee="50">Home Delivery (+₱50)</option>
                                <option value="Pickup" data-fee="0">In-Store Pickup (₱0)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Delivery Address</label>
                            <textarea name="address" id="address" class="styled-input" style="height: 100px; resize: none;" placeholder="Full address for delivery"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method" class="styled-select">
                                <option value="COD">Cash on Delivery</option>
                                <option value="GCash">GCash / E-Wallet</option>
                                <option value="Bank">Bank Transfer</option>
                            </select>
                        </div>

                        <div class="summary-rows">
                            <div class="row">
                                <span>Subtotal</span>
                                <span>₱<?= number_format($cart_total, 2) ?></span>
                            </div>
                            <div class="row">
                                <span>Tax (12% VAT)</span>
                                <span>₱<?= number_format($tax_amount, 2) ?></span>
                            </div>
                            <div class="row">
                                <span>Delivery Fee</span>
                                <span id="display_delivery_fee">₱<?= number_format($delivery_fee, 2) ?></span>
                            </div>
                            <div class="total-row">
                                <span>Total</span>
                                <span id="display_grand_total">₱<?= number_format($grand_total, 2) ?></span>
                            </div>
                        </div>

                        <button type="submit" class="btn-checkout">Complete My Order</button>
                    </form>
                    
                    <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; opacity: 0.5;">
                        <span title="GCash">📱</span>
                        <span title="Bank">🏦</span>
                        <span title="COD">💵</span>
                    </div>
                </aside>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($session->getFlashdata('cart_message')): ?>
        <div id="toast" style="position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 1rem 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1001;">
            <?= esc($session->getFlashdata('cart_message')) ?>
        </div>
        <script>setTimeout(() => document.getElementById('toast').style.display='none', 3000);</script>
    <?php endif; ?>

    <script>
        function updateTotals() {
            const select = document.getElementById('shipping_method');
            const fee = parseFloat(select.options[select.selectedIndex].getAttribute('data-fee'));
            const subtotal = <?= $cart_total ?>;
            const tax = <?= $tax_amount ?>;
            const grandTotal = subtotal + tax + fee;
            
            document.getElementById('display_delivery_fee').innerText = '₱' + fee.toFixed(2);
            document.getElementById('display_grand_total').innerText = '₱' + grandTotal.toFixed(2);
            
            const addressArea = document.getElementById('address');
            if (select.value === 'Pickup') {
                addressArea.value = 'In-Store Pickup';
                addressArea.disabled = true;
            } else {
                addressArea.value = '';
                addressArea.disabled = false;
            }
        }
    </script>
    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>