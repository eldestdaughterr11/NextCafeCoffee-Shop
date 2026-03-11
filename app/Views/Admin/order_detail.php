<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - NextCafe Admin</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>
    
    <?= view('partials/admin_sidebar') ?>

    <div class="main-wrapper">
        <div class="header-top">
            <h1>Order #<?= $order->id ?> Details</h1>
            <div class="header-right">
                <div class="current-date">
                    <?= date('M j, Y') ?>
                </div>
                <div class="user-meta">
                    <div class="user-avatar">
                        <?= strtoupper(substr($user->username ?? 'A', 0, 1)) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-container">
            <div style="display: flex; gap: 2rem;">
                <div class="card" style="flex: 2;">
                    <h3>Items in Order</h3>
                    <table class="data-table" style="margin-top: 1rem;">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <?php 
                                            // Provide fallbacks if image missing or item removed
                                            $imagePath = !empty($item->image_url) ? $item->image_url : 'images/default.jpg'; 
                                            $name = !empty($item->product_name) ? $item->product_name : 'Unknown Product';
                                            ?>
                                            <img src="<?= base_url($imagePath) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            <?= esc($name) ?>
                                        </div>
                                    </td>
                                    <td>x<?= $item->quantity ?></td>
                                    <td>₱<?= number_format($item->price, 2) ?></td>
                                    <td style="font-weight: 600;">₱<?= number_format($item->price * $item->quantity, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: 700;">Grand Total:</td>
                                <td style="font-weight: 700; color: #d4a574;">₱<?= number_format($order->total_amount, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="card" style="flex: 1;">
                    <h3>Order Summary</h3>
                    <div style="margin-top: 1rem; line-height: 1.8;">
                        <div><strong style="color: #666;">Customer:</strong> <?= esc($order->customer_name) ?></div>
                        <div><strong style="color: #666;">Date Placed:</strong> <?= date('F j, Y h:i A', strtotime($order->created_at)) ?></div>
                        <div><strong style="color: #666;">Status:</strong> 
                            <span class="badge <?= $order->status == 'completed' ? 'badge-success' : ($order->status == 'pending' ? 'badge-warning' : 'badge-danger') ?>" style="text-transform: capitalize; padding: 0.2rem 0.5rem; font-size: 0.8rem;">
                                <?= esc($order->status) ?>
                            </span>
                        </div>
                        
                        <hr style="border:0; border-top: 1px solid #eee; margin: 1.5rem 0;">
                        
                        <h4>Update Order Status</h4>
                        <form action="<?= site_url('admin/orders/update') ?>" method="POST" style="margin-top: 1rem;">
                            <input type="hidden" name="order_id" value="<?= $order->id ?>">
                            <select name="status" class="filter-select" style="width: 100%; margin-bottom: 1rem; padding: 0.8rem;">
                                <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="completed" <?= $order->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn-primary" style="width: 100%;">Save Status</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <a href="<?= site_url('admin/orders') ?>" class="btn-secondary" style="display: inline-block; margin-top: 2rem; padding: 0.8rem 1.5rem; text-decoration: none; border-radius: 4px; border: 1px solid #ddd; color: #333;">< Back to Orders</a>
        </div>

        <div class="admin-footer">
            &copy; <?= date('Y') ?> Admin Panel
        </div>
    </div>

    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>
