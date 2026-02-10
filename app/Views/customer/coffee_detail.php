<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($product->product_name) ?> - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/menu.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/reviews.css') ?>">
    <style>
        .detail-container {
            max-width: 1000px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .product-large-image {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            background: #fdfdfd;
            border: 1px solid #eee;
        }

        .product-large-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .product-details-info h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .detail-category {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: #f0f0f0;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .detail-price {
            font-size: 2rem;
            font-weight: 600;
            color: #d4a574;
            margin-bottom: 2rem;
        }

        .detail-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
        }

        .wishlist-btn {
            background: none;
            border: 2px solid #d4a574;
            color: #d4a574;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1rem;
        }

        .wishlist-btn:hover {
            background: #d4a574;
            color: white;
        }

        .wishlist-btn.in-wishlist {
            background: #d4a574;
            color: white;
        }

        .add-to-cart-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            border-top: 1px solid #eee;
            padding-top: 2rem;
        }

        .qty-selector {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .qty-btn:hover {
            background: #f5f5f5;
        }

        .qty-input {
            width: 60px;
            text-align: center;
            font-size: 1.2rem;
            border: none;
            font-weight: 600;
        }

        .btn-add-large {
            background: #d4a574;
            color: white;
            border: none;
            padding: 1.2rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-add-large:hover {
            background: #c39463;
        }

        .reviews-section {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        @media (max-width: 768px) {
            .detail-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
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
            <a href="<?= base_url('customer/cart') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </span>
                Shopping Cart
            </a>
            <a href="<?= base_url('customer/wishlist') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                </span>
                Wishlist
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

    <!-- Main Content -->
    <div class="main-wrapper" style="background: #f8f9fa;">
        <div class="header-top">
            <a href="<?= site_url('customer/menu') ?>" style="text-decoration: none; color: #666; font-weight: 600;">← Back to Menu</a>
            <div class="user-avatar"><?= strtoupper(substr(session()->get('username') ?? 'G', 0, 1)) ?></div>
        </div>

        <div class="detail-container">
            <div class="product-large-image">
                <?php
                $defaultImages = [
                    'Espresso' => 'images/espresso.jpg',
                    'Cappuccino' => 'images/cappuccino.jpg',
                    'Iced Americano' => 'images/iced_americano.png',
                    'Caramel Latte' => 'images/caramel_latte.png',
                    'Blueberry Muffin' => 'images/blueberrymuffin.jpg'
                ];
                $imagePath = !empty($product->image_url) ? $product->image_url : ($defaultImages[$product->product_name] ?? 'images/default.jpg');
                ?>
                <img src="<?= base_url($imagePath) ?>" alt="<?= esc($product->product_name) ?>">
            </div>

            <div class="product-details-info">
                <span class="detail-category"><?= esc($product->category) ?></span>
                <h1><?= esc($product->product_name) ?></h1>
                
                <!-- Rating Display -->
                <?php if ($reviewCount > 0): ?>
                    <div class="rating-display">
                        <span class="stars large">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= floor($averageRating)): ?>
                                    ★
                                <?php else: ?>
                                    ☆
                                <?php endif; ?>
                            <?php endfor; ?>
                        </span>
                        <span class="rating-text"><?= number_format($averageRating, 1) ?> (<?= $reviewCount ?> reviews)</span>
                    </div>
                <?php endif; ?>

                <div class="detail-price">₱<?= number_format($product->price, 2) ?></div>
                <p class="detail-description">
                    <?= esc($product->description ?? 'Experience the rich and authentic taste of our premium selection. Carefully curated and brewed to perfection.') ?>
                </p>

                <!-- Wishlist Button -->
                <?php if (session()->get('logged_in')): ?>
                    <button class="wishlist-btn <?= $inWishlist ? 'in-wishlist' : '' ?>" 
                            onclick="toggleWishlist(<?= $product->id ?>, this)">
                        ❤️ <?= $inWishlist ? 'In Wishlist' : 'Add to Wishlist' ?>
                    </button>
                <?php endif; ?>

                <form action="<?= site_url('customer/add_to_cart') ?>" method="POST" class="add-to-cart-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                    <input type="hidden" name="product_name" value="<?= esc($product->product_name) ?>">
                    <input type="hidden" name="price" value="<?= $product->price ?>">
                    
                    <div class="qty-selector">
                        <label style="font-weight: 600; color: #333;">Quantity:</label>
                        <button type="button" class="qty-btn" onclick="const input = document.getElementById('qty'); if(input.value > 1) input.value--;">-</button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="99" class="qty-input" readonly>
                        <button type="button" class="qty-btn" onclick="const input = document.getElementById('qty'); input.value++;">+</button>
                    </div>

                    <button type="submit" class="btn-add-large">Add to Cart</button>
                </form>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-section">
            <h2>Customer Reviews</h2>

            <!-- Display alerts -->
            <?php if (session()->getFlashdata('review_success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('review_success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('review_error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('review_error') ?>
                </div>
            <?php endif; ?>

            <!-- Average Rating Summary -->
            <?php if ($reviewCount > 0): ?>
                <div class="rating-summary">
                    <div class="rating-score">
                        <div class="rating-number"><?= number_format($averageRating, 1) ?></div>
                        <div class="stars large">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= floor($averageRating)): ?>
                                    ★
                                <?php else: ?>
                                    ☆
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="rating-total"><?= $reviewCount ?> review<?= $reviewCount > 1 ? 's' : '' ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Review Form (Only for logged-in users who purchased the product) -->
            <?php if (session()->get('logged_in')): ?>
                <?php if ($hasPurchased && !$hasReviewed): ?>
                    <div class="review-form">
                        <h3>Write a Review</h3>
                        <form action="<?= site_url('customer/review/submit') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $product->id ?>">
                            
                            <div class="form-group">
                                <label>Rating:</label>
                                <div class="star-rating-input">
                                    <input type="radio" id="star5" name="rating" value="5" required>
                                    <label for="star5">★</label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4">★</label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3">★</label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2">★</label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1">★</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="review_text">Your Review:</label>
                                <textarea class="review-text-input" id="review_text" name="review_text" 
                                          placeholder="Share your thoughts about this product..." 
                                          maxlength="500"></textarea>
                            </div>

                            <button type="submit" class="btn-submit-review">Submit Review</button>
                        </form>
                    </div>
                <?php elseif ($hasReviewed): ?>
                    <div class="alert alert-info">
                        You have already reviewed this product. You can delete your review below.
                    </div>
                <?php elseif (!$hasPurchased): ?>
                    <div class="purchase-required">
                        📦 Purchase this product to leave a review
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Please <a href="<?= site_url('login') ?>">log in</a> to leave a review.
                </div>
            <?php endif; ?>

            <!-- Reviews List -->
            <div class="reviews-list">
                <?php if (empty($reviews)): ?>
                    <div class="no-reviews">
                        <div class="no-reviews-icon">💭</div>
                        <p>No reviews yet. Be the first to review this product!</p>
                    </div>
                <?php else: ?>
                    <h3>All Reviews (<?= count($reviews) ?>)</h3>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <div class="review-user-info">
                                    <div class="review-avatar">
                                        <?= strtoupper(substr($review->user_name ?? $review->username, 0, 1)) ?>
                                    </div>
                                    <div class="review-user-details">
                                        <h4><?= esc($review->user_name ?? $review->username) ?></h4>
                                        <div class="review-date">
                                            <?= date('F j, Y', strtotime($review->created_at)) ?>
                                       </div>
                                    </div>
                                </div>
                                <?php if (session()->get('user_id') == $review->user_id): ?>
                                    <div class="review-actions">
                                        <form action="<?= site_url('customer/review/delete/' . $review->id) ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn-delete-review" 
                                                    onclick="return confirm('Are you sure you want to delete this review?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="review-rating">
                                <span class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review->rating): ?>
                                            ★
                                        <?php else: ?>
                                            ☆
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </span>
                            </div>
                            <?php if (!empty($review->review_text)): ?>
                                <p class="review-text"><?= esc($review->review_text) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleWishlist(productId, button) {
            const isInWishlist = button.classList.contains('in-wishlist');
            const url = '<?= site_url('customer/wishlist/add') ?>';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'product_id=' + productId + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('in-wishlist');
                    button.textContent = button.classList.contains('in-wishlist') 
                        ? '❤️ In Wishlist' 
                        : '❤️ Add to Wishlist';
                }
            });
        }
    </script>
    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>

</html>
