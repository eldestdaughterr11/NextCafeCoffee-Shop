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
                    <div class="search-filter">
                        <div class="search-input">
                            <i class="fas fa-search icon"></i>
                            <input type="text" placeholder="Search product...">
                        </div>
                        <select class="filter-select">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= esc($cat->category) ?>"><?= esc($cat->category) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select class="filter-select">
                            <option value="">All Status</option>
                            <option value="available">Active</option>
                            <option value="unavailable">Inactive</option>
                        </select>
                        <select class="filter-select">
                            <option value="">Sort by</option>
                            <option value="name">Name</option>
                            <option value="price">Price</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn-primary" style="padding: 0.65rem 1.5rem;">Apply</button>
                        <button class="btn-secondary">Reset</button>
                    </div>
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
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td style="color: var(--text-muted); font-size: 0.8rem;">
                                            <?= date('M j, Y h:i A', strtotime($product->created_at)) ?>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="<?= base_url('admin/products/edit/' . $product->id) ?>" class="btn-icon btn-yellow" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-icon btn-cyan" title="View">
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
