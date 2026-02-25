<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
</head>
<body>
    
    <?= view('partials/admin_sidebar') ?>

    <div class="main-wrapper">
        <div class="header-top">
            <h1>Category Management</h1>
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
                    <h2 style="font-size: 1.25rem; font-weight: 700;">All Categories</h2>
                    <a href="#" class="btn-primary">+ Add Category</a>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Total Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categories)): ?>
                                <tr><td colspan="4" style="text-align: center; padding: 3rem;">No categories found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($categories as $index => $cat): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td style="font-weight: 600;"><?= esc($cat->category) ?></td>
                                        <td><?= $cat->product_count ?> Items</td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="<?= base_url('admin/products?category=' . urlencode($cat->category)) ?>" class="btn-icon btn-cyan" title="View Products">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn-icon btn-yellow" title="Edit">
                                                    <i class="fas fa-edit"></i>
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
