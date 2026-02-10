<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - NextCafe Admin</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <style>
        .form-container { max-width: 600px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        .form-control { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; }
        .btn-submit { background: #6F4E37; color: white; border: none; padding: 1rem 2rem; border-radius: 8px; cursor: pointer; font-size: 1rem; width: 100%; }
    </style>
</head>
<body style="background: #f8f9fa;">
    <div class="form-container">
        <h1>Edit Product: <?= esc($product->product_name) ?></h1>
        <form action="<?= site_url('admin/products/update/' . $product->id) ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control" value="<?= esc($product->product_name) ?>" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" class="form-control" required>
                    <option value="Espresso" <?= $product->category == 'Espresso' ? 'selected' : '' ?>>Espresso</option>
                    <option value="Milk Based" <?= $product->category == 'Milk Based' ? 'selected' : '' ?>>Milk Based</option>
                    <option value="Cold Brew" <?= $product->category == 'Cold Brew' ? 'selected' : '' ?>>Cold Brew</option>
                    <option value="Pastries" <?= $product->category == 'Pastries' ? 'selected' : '' ?>>Pastries</option>
                </select>
            </div>
            <div class="form-group">
                <label>Price (₱)</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= esc($product->price) ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"><?= esc($product->description) ?></textarea>
            </div>
            <div class="form-group">
                <label>Current Image</label>
                <img src="<?= base_url($product->image_url) ?>" style="height: 100px; display: block; margin-bottom: 0.5rem;">
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="available" <?= $product->status == 'available' ? 'selected' : '' ?>>Available</option>
                    <option value="unavailable" <?= $product->status == 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Update Product</button>
            <a href="<?= site_url('admin/dashboard') ?>" style="display: block; text-align: center; margin-top: 1rem; color: #666;">Cancel</a>
        </form>
    </div>
</body>
</html>
