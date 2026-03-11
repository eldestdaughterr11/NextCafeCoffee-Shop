<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <style>
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background-color: var(--success-color, #2ecc71); color: white; }
        .badge-danger { background-color: var(--danger-color, #e74c3c); color: white; }
        .btn-icon { color: white; width: 32px; height: 32px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
    </style>
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
            <?php if(session()->getFlashdata('success')): ?>
                <div style="background-color: var(--success-color, #2ecc71); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div style="background-color: var(--danger-color, #e74c3c); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="card-wrapper">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">All Categories</h2>
                    <a href="<?= base_url('admin/categories/add') ?>" class="btn-primary">+ Add Category</a>
                </div>

                <div class="table-header">
                    <form action="<?= base_url('admin/categories') ?>" method="GET" style="width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <div class="search-filter" style="display: flex; gap: 1rem; flex-grow: 1;">
                            <select class="filter-select" name="search">
                                <option value="">All Categories</option>
                                <?php foreach ($categoriesList as $catList): ?>
                                    <option value="<?= esc($catList->name) ?>" <?= (isset($_GET['search']) && $_GET['search'] == $catList->name) ? 'selected' : '' ?>><?= esc($catList->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="filter-select" name="status">
                                <option value="">All Status</option>
                                <option value="active" <?= (isset($_GET['status']) && $_GET['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= (isset($_GET['status']) && $_GET['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <select class="filter-select" name="sort">
                                <option value="">Sort by</option>
                                <option value="name" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name') ? 'selected' : '' ?>>Name</option>
                                <option value="slug" <?= (isset($_GET['sort']) && $_GET['sort'] == 'slug') ? 'selected' : '' ?>>Slug</option>
                            </select>
                            <select class="filter-select" name="order">
                                <option value="ASC" <?= (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'selected' : '' ?>>Ascending</option>
                                <option value="DESC" <?= (isset($_GET['order']) && $_GET['order'] == 'DESC') ? 'selected' : '' ?>>Descending</option>
                            </select>
                        </div>
                        <div style="display: flex; gap: 0.5rem; margin-top: 10px;">
                            <button type="submit" class="btn-primary" style="padding: 0.65rem 1.5rem;">Apply</button>
                            <a href="<?= base_url('admin/categories') ?>" class="btn-secondary" style="padding: 0.65rem 1.5rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Reset</a>
                        </div>
                    </form>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categories)): ?>
                                <tr><td colspan="5" style="text-align: center; padding: 3rem;">No categories found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($categories as $index => $cat): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td style="font-weight: 600;"><?= esc($cat->name) ?></td>
                                        <td><?= esc($cat->slug) ?></td>
                                        <td>
                                            <?php if ($cat->status === 'active'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="<?= base_url('admin/products?category=' . urlencode($cat->name)) ?>" class="btn-icon" style="background-color: #3498db;" title="View Products">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </a>
                                                <a href="<?= base_url('admin/categories/edit/' . $cat->id) ?>" class="btn-icon" style="background-color: #f1c40f;" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </a>
                                                <a href="<?= base_url('admin/categories/toggle/' . $cat->id) ?>" class="btn-icon" style="background-color: <?= ($cat->status === 'active') ? 'var(--danger-color, #e74c3c)' : 'var(--success-color, #2ecc71)' ?>;" title="<?= ($cat->status === 'active') ? 'Disable' : 'Enable' ?>">
                                                    <?php if ($cat->status === 'active'): ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                                                    <?php else: ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    <?php endif; ?>
                                                </a>
                                                <a href="<?= base_url('admin/categories/delete/' . $cat->id) ?>" class="btn-icon" style="background-color: #c0392b; color: white; width: 32px; height: 32px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;" title="Delete" onclick="return confirm('Are you sure you want to permanently delete this category? All associated products will lose their category link. This cannot be undone.')">
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
