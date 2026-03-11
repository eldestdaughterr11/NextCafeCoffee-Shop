<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - NextCafe</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
</head>
<body>
    <?= view('partials/admin_sidebar') ?>
    <div class="main-wrapper">
        <div class="header-top">
            <h1>Add Category</h1>
        </div>
        <div class="content-container">
            <div class="card-wrapper" style="max-width: 600px; margin: 0 auto;">
                <form action="<?= base_url('admin/categories/store') ?>" method="POST">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Category Name <span style="color:red">*</span></label>
                        <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Status</label>
                        <select name="status" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <a href="<?= base_url('admin/categories') ?>" class="btn-secondary" style="padding: 0.75rem 1.5rem; text-decoration: none;">Cancel</a>
                        <button type="submit" class="btn-primary" style="padding: 0.75rem 1.5rem; border: none; cursor: pointer; border-radius: 8px;">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="admin-footer">&copy; <?= date('Y') ?> Admin Panel</div>
    </div>
</body>
</html>
