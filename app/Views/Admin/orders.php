<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
</head>
<body>
    
    <?= view('partials/admin_sidebar') ?>

    <div class="main-wrapper">
        <div class="header-top">
            <h1>Order Management</h1>
            <div class="header-right">
                <div class="current-date">
                    <i class="far fa-calendar"></i> <?= date('M j, Y') ?>
                </div>
                <div class="user-meta">
                    <div class="user-avatar">
                        <?= strtoupper(substr($user->username ?? 'A', 0, 1)) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-container">
            <div class="card-wrapper">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">All Orders</h2>
                </div>

                <div class="table-header">
                    <div class="search-filter">
                        <div class="search-input">
                            <i class="fas fa-search icon"></i>
                            <input type="text" placeholder="Search order ID or customer...">
                        </div>
                        <select class="filter-select">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <select class="filter-select">
                            <option value="">Sort by</option>
                            <option value="newest">Newest First</option>
                            <option value="amount">Amount</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn-primary" style="padding: 0.65rem 1.5rem;">Apply</button>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>OrderID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Update Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr><td colspan="7" style="text-align: center; padding: 3rem;">No orders found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td style="font-weight: 600;">#<?= $order->id ?></td>
                                        <td><?= esc($order->customer_name) ?></td>
                                        <td style="color: var(--text-muted);"><?= date('M j, Y h:i A', strtotime($order->created_at)) ?></td>
                                        <td style="font-weight: 600;">₱<?= number_format($order->total_amount, 2) ?></td>
                                        <td>
                                            <span class="badge <?= $order->status == 'completed' ? 'badge-success' : ($order->status == 'pending' ? 'badge-warning' : 'badge-danger') ?>" style="text-transform: capitalize;">
                                                <?= esc($order->status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form action="<?= site_url('admin/orders/update') ?>" method="POST" style="display: flex; align-items: center;">
                                                <input type="hidden" name="order_id" value="<?= $order->id ?>">
                                                <select name="status" onchange="this.form.submit()" class="filter-select" style="padding: 0.35rem; font-size: 0.8rem; min-width: 120px;">
                                                    <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="completed" <?= $order->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                    <option value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="#" class="btn-icon btn-cyan" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="admin-footer">
            &copy; <?= date('Y') ?> Admin Panel
        </div>
    </div>

    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>
