<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <style>
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background-color: var(--success-color, #2ecc71); color: white; }
        .badge-danger { background-color: var(--danger-color, #e74c3c); color: white; }
        .badge-info { background-color: #3498db; color: white; }
        .btn-icon { color: white; width: 32px; height: 32px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
    </style>
</head>
<body>
    
    <?= view('partials/admin_sidebar') ?>

    <div class="main-wrapper">
        <div class="header-top">
            <h1>User Management</h1>
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
                    <h2 style="font-size: 1.25rem; font-weight: 700;">All Users</h2>
                </div>

                <div class="table-header">
                    <form action="<?= base_url('admin/users') ?>" method="GET" style="width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <div class="search-filter" style="display: flex; gap: 1rem; flex-grow: 1;">
                            <div class="search-input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" name="search" value="<?= isset($_GET['search']) ? esc($_GET['search']) : '' ?>" placeholder="Search user..." style="padding-left: 2.2rem;">
                            </div>
                            <select class="filter-select" name="role">
                                <option value="">All Roles</option>
                                <option value="admin" <?= (isset($_GET['role']) && $_GET['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="customer" <?= (isset($_GET['role']) && $_GET['role'] == 'customer') ? 'selected' : '' ?>>Customer</option>
                            </select>
                            <select class="filter-select" name="status">
                                <option value="">All Status</option>
                                <option value="active" <?= (isset($_GET['status']) && $_GET['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= (isset($_GET['status']) && $_GET['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <select class="filter-select" name="sort">
                                <option value="">Sort by</option>
                                <option value="name" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name') ? 'selected' : '' ?>>Name</option>
                                <option value="created_at" <?= (isset($_GET['sort']) && $_GET['sort'] == 'created_at') ? 'selected' : '' ?>>Join Date</option>
                            </select>
                            <select class="filter-select" name="order">
                                <option value="ASC" <?= (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'selected' : '' ?>>Ascending</option>
                                <option value="DESC" <?= (isset($_GET['order']) && $_GET['order'] == 'DESC') ? 'selected' : '' ?>>Descending</option>
                            </select>
                        </div>
                        <div style="display: flex; gap: 0.5rem; margin-top: 10px;">
                            <button type="submit" class="btn-primary" style="padding: 0.65rem 1.5rem;">Apply</button>
                            <a href="<?= base_url('admin/users') ?>" class="btn-secondary" style="padding: 0.65rem 1.5rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Reset</a>
                        </div>
                    </form>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email / Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($usersList)): ?>
                                <tr><td colspan="7" style="text-align: center; padding: 3rem;">No users found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($usersList as $index => $u): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td style="font-weight: 600;"><?= esc($u->name) ?></td>
                                        <td>
                                            <?= esc($u->email) ?><br>
                                            <small style="color: var(--text-muted);">@<?= esc($u->username) ?></small>
                                        </td>
                                        <td>
                                            <?php if ($u->role === 'admin'): ?>
                                                <span class="badge badge-info">Admin</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary" style="background-color: #95a5a6; color: white;">Customer</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($u->status === 'active'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="color: var(--text-muted); font-size: 0.8rem;">
                                            <?= date('M j, Y', strtotime($u->created_at)) ?>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="<?= base_url('admin/users/edit/' . $u->id) ?>" class="btn-icon" style="background-color: #f1c40f;" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </a>
                                                <?php if($u->id != $user->id && $u->role !== 'admin'): ?>
                                                <a href="<?= base_url('admin/users/toggle/' . $u->id) ?>" class="btn-icon" style="background-color: <?= ($u->status === 'active') ? 'var(--danger-color, #e74c3c)' : 'var(--success-color, #2ecc71)' ?>;" title="<?= ($u->status === 'active') ? 'Disable' : 'Enable' ?>">
                                                    <?php if ($u->status === 'active'): ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                                                    <?php else: ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    <?php endif; ?>
                                                </a>
                                                <a href="<?= base_url('admin/users/delete/' . $u->id) ?>" class="btn-icon" style="background-color: #c0392b;" title="Delete User" onclick="return confirm('Are you sure you want to permanently delete user &quot;<?= esc($u->username) ?>&quot;? This cannot be undone.')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M9 6V4h6v2"></path></svg>
                                                </a>
                                                <?php endif; ?>
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
