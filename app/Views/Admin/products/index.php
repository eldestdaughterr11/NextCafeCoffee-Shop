<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
</head>
<body>
    
    <?= view('partials/admin_sidebar') ?>

    <div class="main-wrapper">
        <div class="header-top">
            <h1>Dashboard</h1>
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
                    <h2 style="font-size: 1.25rem; font-weight: 700;">Product Management</h2>
                    <a href="<?= base_url('admin/products/add') ?>" class="btn-primary">+ Add Product</a>
                </div>

                <div class="table-header">
                    <form action="<?= base_url('admin/products') ?>" method="GET" style="width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <div class="search-filter" style="display: flex; gap: 1rem; flex-grow: 1;">
                            <div class="search-input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" name="search" value="<?= isset($_GET['search']) ? esc($_GET['search']) : '' ?>" placeholder="Search product..." style="padding-left: 2.2rem;">
                            </div>
                            <select class="filter-select" name="category">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat->name) ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat->name) ? 'selected' : '' ?>><?= esc($cat->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="filter-select" name="status">
                                <option value="">All Status</option>
                                <option value="available" <?= (isset($_GET['status']) && $_GET['status'] == 'available') ? 'selected' : '' ?>>Active</option>
                                <option value="unavailable" <?= (isset($_GET['status']) && $_GET['status'] == 'unavailable') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <select class="filter-select" name="sort">
                                <option value="">Sort by</option>
                                <option value="product_name" <?= (isset($_GET['sort']) && $_GET['sort'] == 'product_name') ? 'selected' : '' ?>>Name</option>
                                <option value="price" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price') ? 'selected' : '' ?>>Price</option>
                            </select>
                            <select class="filter-select" name="order">
                                <option value="ASC" <?= (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'selected' : '' ?>>Ascending</option>
                                <option value="DESC" <?= (isset($_GET['order']) && $_GET['order'] == 'DESC') ? 'selected' : '' ?>>Descending</option>
                            </select>
                        </div>
                        <div style="display: flex; gap: 0.5rem; margin-top: 10px;">
                            <button type="submit" class="btn-primary" style="padding: 0.65rem 1.5rem;">Apply</button>
                            <a href="<?= base_url('admin/products') ?>" class="btn-secondary" style="padding: 0.65rem 1.5rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Reset</a>
                        </div>
                    </form>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)): ?>
                                <tr><td colspan="8" style="text-align: center; padding: 3rem;">No products found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($products as $index => $product): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td style="font-weight: 600;"><?= esc($product->product_name) ?></td>
                                        <td style="color: var(--text-muted); max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?= esc($product->description) ?>
                                        </td>
                                        <td style="font-weight: 600;">₱<?= number_format($product->price, 2) ?></td>
                                        <td><?= esc($product->category) ?></td>
                                        <td>
                                            <?php if ($product->status === 'available'): ?>
                                                <span class="badge badge-success" style="background-color: var(--success-color); color: white; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem;">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger" style="background-color: var(--danger-color); color: white; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem;">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="color: var(--text-muted); font-size: 0.8rem;">
                                            <?= date('M j, Y h:i A', strtotime($product->created_at)) ?>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="<?= base_url('admin/products/edit/' . $product->id) ?>" class="btn-icon btn-yellow" title="Edit" style="background-color: #f1c40f; color: white; width: 32px; height: 32px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </a>
                                                <a href="<?= base_url('admin/products/toggle/' . $product->id) ?>" class="btn-icon" style="background-color: <?= ($product->status === 'available') ? 'var(--danger-color, #e74c3c)' : 'var(--success-color, #2ecc71)' ?>; color: white; width: 32px; height: 32px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;" title="<?= ($product->status === 'available') ? 'Disable' : 'Enable' ?>">
                                                    <?php if ($product->status === 'available'): ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                                                    <?php else: ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    <?php endif; ?>
                                                </a>
                                                <a href="<?= base_url('admin/products/delete/' . $product->id) ?>" class="btn-icon" style="background-color: #c0392b; color: white; width: 32px; height: 32px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;" title="Delete" onclick="return confirm('Are you sure you want to permanently delete this product? This cannot be undone.')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M9 6V4h6v2"></path></svg>
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
