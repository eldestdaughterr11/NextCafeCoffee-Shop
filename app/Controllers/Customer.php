<?php

namespace App\Controllers;

class Customer extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'customer') {
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();
        $coffees = $db->table('products')
            ->select('products.*')
            ->join('categories', 'categories.name = products.category')
            ->where('products.status', 'available')
            ->where('categories.status', 'active')
            ->get()->getResult();
        
        // Load wishlist
        $wishlistModel = new \App\Models\WishlistModel();
        $userId = session()->get('user_id');
        $wishlistItems = $wishlistModel->getUserWishlist($userId);
        
        // Get only first 3 wishlist items for dashboard preview
        $wishlistPreview = array_slice($wishlistItems, 0, 3);
        
        // Get active categories for Quick Links
        $categories = $db->table('categories')->where('status', 'active')->orderBy('name')->get()->getResult();
        
        return view('customer/dashboard', [
            'coffees' => $coffees,
            'categories' => $categories,
            'wishlistItems' => $wishlistPreview,
            'wishlistCount' => count($wishlistItems)
        ]);
    }

    public function orderDetail($id)
    {
        if (!session()->get('logged_in') || session()->get('role') != 'customer') {
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();
        $order = $db->table('orders')
            ->where('id', $id)
            ->where('user_id', session()->get('user_id'))
            ->get()
            ->getRow();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Order not found");
        }

        $items = $db->table('order_items')
            ->select('order_items.*, products.product_name, products.image_url')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_id', $id)
            ->get()
            ->getResult();

        return view('customer/order_detail', [
            'order' => $order,
            'items' => $items,
            'username' => session()->get('username')
        ]);
    }


    public function contact()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'customer') {
            return redirect()->to(site_url('login'));
        }
        return view('customer/contact');
    }

    public function about()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'customer') {
            return redirect()->to(site_url('login'));
        }
        return view('customer/about');
    }

    public function profile()
    {
        // Ensure customer is logged in
        if (!session()->get('logged_in') || session()->get('role') != 'customer') {
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')
            ->where('id', session()->get('user_id'))
            ->get()
            ->getRow();

        return view('customer/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'customer') {
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        $user = $db->table('users')->where('id', $userId)->get()->getRow();

        $currentPassword = $this->request->getPost('current_password');

        // Support both MD5 (legacy) and bcrypt passwords — mirrors login logic
        $validPassword = false;
        if (strlen($user->password) == 32) {
            $validPassword = md5($currentPassword) === $user->password;
        } else {
            $validPassword = password_verify($currentPassword, $user->password);
        }

        if (!$validPassword) {
            return redirect()->to(site_url('customer/profile'))
                ->with('profile_error', 'Incorrect current password. No changes were saved.');
        }

        $data = [
            'name'       => $this->request->getPost('name'),
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Handle optional password change; always store as bcrypt
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!empty($newPassword)) {
            if ($newPassword !== $confirmPassword) {
                return redirect()->to(site_url('customer/profile'))
                    ->with('profile_error', 'New passwords do not match. No changes were saved.');
            }
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        } elseif (strlen($user->password) == 32) {
            // Silently upgrade legacy MD5 password to bcrypt using the confirmed current password
            $data['password'] = password_hash($currentPassword, PASSWORD_DEFAULT);
        }

        $db->table('users')->where('id', $userId)->update($data);

        // Keep session in sync with new username
        session()->set('username', $data['username']);

        return redirect()->to(site_url('customer/profile'))
            ->with('profile_success', 'Your profile has been updated successfully!');
    }
    public function menu()
    {
        $db = \Config\Database::connect();

        // Get search and sort parameters
        $search = $this->request->getGet('search');
        $sort   = $this->request->getGet('sort');
        $selected_category = $this->request->getGet('category') ?? 'all';

        // Get all available categories for sidebar
        $categories = $db->table('categories')
            ->where('status', 'active')
            ->orderBy('name')
            ->get()
            ->getResult();

        // Build product query, filtering by products available AND category active
        $products_table = $db->table('products')
            ->select('products.*')
            ->join('categories', 'categories.name = products.category')
            ->where('products.status', 'available')
            ->where('categories.status', 'active');

        // Apply search filter
        if (!empty($search)) {
            $products_table->like('product_name', $search);
        }

        // Apply category filter
        if ($selected_category !== 'all') {
            $products_table->where('category', $selected_category);
        }

        // Apply sorting
        if ($sort === 'price_asc') {
            $products_table->orderBy('price', 'ASC');
        } elseif ($sort === 'price_desc') {
            $products_table->orderBy('price', 'DESC');
        } else {
            $products_table->orderBy('id', 'DESC');
        }

        $products = $products_table->get()->getResult();

        return view('customer/menu', [
            'username'          => session()->get('username'),
            'categories'        => $categories,
            'selected_category' => $selected_category,
            'products'          => $products,
            'search'            => $search,
            'sort'              => $sort,
            'cart_count'        => session()->get('cart_count') ?? 0
        ]);
    }

    public function viewProduct($slug)
    {
        $db = \Config\Database::connect();
        $product = $db->table('products')
            ->select('products.*')
            ->join('categories', 'categories.name = products.category')
            ->where('products.slug', $slug)
            ->where('products.status', 'available')
            ->where('categories.status', 'active')
            ->get()
            ->getRow();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product not found");
        }

        // Load review model
        $reviewModel = new \App\Models\ReviewModel();
        $wishlistModel = new \App\Models\WishlistModel();
        
        // Get reviews and ratings
        $reviews = $reviewModel->getProductReviews($product->id);
        $ratingData = $reviewModel->getAverageRating($product->id);
        
        // Check if user is logged in and has purchased/reviewed
        $userId = session()->get('user_id');
        $hasPurchased = false;
        $hasReviewed = false;
        $userReview = null;
        $inWishlist = false;
        
        if ($userId) {
            $hasPurchased = $reviewModel->hasUserPurchased($userId, $product->id);
            $hasReviewed = $reviewModel->hasUserReviewed($userId, $product->id);
            $userReview = $reviewModel->getUserReview($userId, $product->id);
            $inWishlist = $wishlistModel->isInWishlist($userId, $product->id);
        }

        return view('customer/coffee_detail', [
            'product' => $product,
            'username' => session()->get('username'),
            'reviews' => $reviews,
            'averageRating' => $ratingData['average'],
            'reviewCount' => $ratingData['count'],
            'hasPurchased' => $hasPurchased,
            'hasReviewed' => $hasReviewed,
            'userReview' => $userReview,
            'inWishlist' => $inWishlist
        ]);
    }


    public function logout()
    {
        // Simulang i-destroy ang session
        session()->destroy();

        // Redirect sa login page o homepage
        return redirect()->to(site_url('login'));
    }

    public function add_to_cart()
    {
        $session = session();

        // Get POST data
        $product_id   = $this->request->getPost('product_id');
        $product_name = $this->request->getPost('product_name');
        $price        = $this->request->getPost('price');

        // Map product names to images
        $images = [
            'Espresso' => 'images/espresso.jpg',
            'Cappuccino' => 'images/cappuccino.jpg',
            'Blueberry Muffin' => 'images/blueberrymuffin.jpg'
        ];

        // Prepare cart item with keys matching view
        $quantity = (int) $this->request->getPost('quantity');
        if ($quantity < 1) $quantity = 1;

        $cartItem = [
            'product_id' => $product_id,
            'name'       => $product_name,             // <-- match $item['name']
            'price'      => $price,
            'quantity'   => $quantity,
            'image'      => $images[$product_name] ?? 'images/default.jpg' // <-- match $item['image']
        ];

        // Get existing cart
        $cart = $session->get('cart') ?? [];

        // Add / update quantity
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $cart[$product_id] = $cartItem;
        }

        // Save cart
        $session->set('cart', $cart);

        // Optional: flash message
        return redirect()->back()->with('cart_message', "$product_name added to cart!");
    }



    public function cart()
    {
        $session = session();

        // Get cart from session
        $cart = $session->get('cart') ?? [];

        $db = \Config\Database::connect();
        
        // Normalize items and fetch latest info from DB
        foreach ($cart as $pid => $item) {
            $liveProduct = $db->table('products')
                ->select('products.*')
                ->join('categories', 'categories.name = products.category', 'left')
                ->where('products.id', $pid)
                ->where('products.status', 'available')
                ->where('categories.status', 'active')
                ->get()->getRow();
            
            if ($liveProduct) {
                // Update session cart with latest database values
                $cart[$pid]['product_name'] = $liveProduct->product_name;
                $cart[$pid]['name'] = $liveProduct->product_name;
                $cart[$pid]['image'] = $liveProduct->image_url;
                $cart[$pid]['image_url'] = $liveProduct->image_url;
                // Optional: update price too, so cart reflects live price changes
                $cart[$pid]['price'] = $liveProduct->price;
                
                if (!isset($item['quantity'])) {
                    $cart[$pid]['quantity'] = $item['quantity'] ?? 1;
                }
            } else {
                // Remove from cart if product becomes unavailable or category is inactive
                unset($cart[$pid]);
            }
        }
        
        // Save the refreshed data back to session
        $session->set('cart', $cart);

        $cart_count = array_sum(array_column($cart, 'quantity'));

        $data = [
            'cart' => $cart,
            'cart_count' => $cart_count,
            'username' => $session->get('username') ?? 'Guest'
        ];

        return view('customer/cart', $data);
    }


    public function update_cart()
    {
        $session = session();

        $product_id = $this->request->getPost('product_id');
        $action = $this->request->getPost('action');

        $cart = $session->get('cart') ?? [];

        if (isset($cart[$product_id])) {
            if ($action === 'increase') {
                $cart[$product_id]['quantity']++;
            } elseif ($action === 'decrease' && $cart[$product_id]['quantity'] > 1) {
                $cart[$product_id]['quantity']--;
            }
        }

        $session->set('cart', $cart);
        return redirect()->to(site_url('customer/cart'));
    }

    public function remove_from_cart()
    {
        $session = session();
        $product_id = $this->request->getPost('product_id');
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            $session->setFlashdata('cart_message', 'Item removed from cart.');
        }

        $session->set('cart', $cart);
        return redirect()->to(site_url('customer/cart'));
    }

    public function clear_cart()
    {
        $session = session();
        $session->remove('cart');
        $session->setFlashdata('cart_message', 'Cart cleared.');
        return redirect()->to(site_url('customer/cart'));
    }

    public function checkout()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            $session->setFlashdata('cart_message', 'Your cart is empty!');
            return redirect()->to(site_url('customer/cart'));
        }

        $userId = $session->get('user_id');
        $shippingMethod = $this->request->getPost('shipping_method');
        $paymentMethod = $this->request->getPost('payment_method');
        $address = $this->request->getPost('address');

        // Calculate totals
        $cartTotal = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }
        $tax = $cartTotal * 0.12;
        $deliveryFee = ($shippingMethod === 'Delivery') ? 50 : 0;
        $grandTotal = $cartTotal + $tax + $deliveryFee;

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Save Order
        $orderData = [
            'user_id'         => $userId,
            'total_amount'    => $grandTotal,
            'status'          => 'pending',
            'shipping_method' => $shippingMethod,
            'payment_method'  => $paymentMethod,
            'address'         => $address,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];
        $db->table('orders')->insert($orderData);
        $orderId = $db->insertID();

        // 2. Save Order Items
        foreach ($cart as $productId => $item) {
            $itemData = [
                'order_id'   => $orderId,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $db->table('order_items')->insert($itemData);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            $session->setFlashdata('cart_message', 'Checkout failed. Please try again.');
            return redirect()->to(site_url('customer/cart'));
        }

        // 3. Clear Cart and Success
        $session->remove('cart');
        $session->set('cart_count', 0);
        $session->setFlashdata('cart_message', 'Order placed successfully! Order ID: #' . $orderId);

        return redirect()->to(site_url('customer/orders'));
    }

    public function orders()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();
        $orders = $db->table('orders')
            ->where('user_id', $session->get('user_id'))
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        return view('customer/orders', [
            'orders' => $orders,
            'username' => $session->get('username')
        ]);
    }

    // ============================================
    // WISHLIST METHODS
    // ============================================

    public function wishlist()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'customer') {
            return redirect()->to(site_url('login'));
        }

        $wishlistModel = new \App\Models\WishlistModel();
        $reviewModel = new \App\Models\ReviewModel();
        $userId = session()->get('user_id');
        
        $wishlistItems = $wishlistModel->getUserWishlist($userId);
        
        // Get ratings for each product
        foreach ($wishlistItems as &$item) {
            $ratingData = $reviewModel->getAverageRating($item->product_id);
            $item->averageRating = $ratingData['average'];
            $item->reviewCount = $ratingData['count'];
        }

        return view('customer/wishlist', [
            'wishlistItems' => $wishlistItems,
            'username' => session()->get('username')
        ]);
    }

    public function addToWishlist()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Please login first']);
        }

        $productId = $this->request->getPost('product_id');
        $userId = session()->get('user_id');

        $wishlistModel = new \App\Models\WishlistModel();
        $result = $wishlistModel->addToWishlist($userId, $productId);

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Added to wishlist']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Already in wishlist']);
        }
    }

    public function removeFromWishlist()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'));
        }

        $productId = $this->request->getPost('product_id');
        $userId = session()->get('user_id');

        $wishlistModel = new \App\Models\WishlistModel();
        $wishlistModel->removeFromWishlist($userId, $productId);

        session()->setFlashdata('wishlist_message', 'Item removed from wishlist');
        return redirect()->back();
    }

    // ============================================
    // REVIEW METHODS
    // ============================================

    public function submitReview()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'));
        }

        $userId = session()->get('user_id');
        $productId = $this->request->getPost('product_id');
        $rating = $this->request->getPost('rating');
        $reviewText = $this->request->getPost('review_text');

        $reviewModel = new \App\Models\ReviewModel();

        // Check if user has purchased the product
        if (!$reviewModel->hasUserPurchased($userId, $productId)) {
            session()->setFlashdata('review_error', 'You can only review products you have purchased');
            return redirect()->back();
        }

        // Check if user has already reviewed
        if ($reviewModel->hasUserReviewed($userId, $productId)) {
            session()->setFlashdata('review_error', 'You have already reviewed this product');
            return redirect()->back();
        }

        $data = [
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $rating,
            'review_text' => $reviewText
        ];

        if ($reviewModel->insert($data)) {
            session()->setFlashdata('review_success', 'Review submitted successfully!');
        } else {
            session()->setFlashdata('review_error', 'Failed to submit review');
        }

        return redirect()->back();
    }

    public function deleteReview($reviewId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'));
        }

        $userId = session()->get('user_id');
        $reviewModel = new \App\Models\ReviewModel();

        if ($reviewModel->deleteUserReview($reviewId, $userId)) {
            session()->setFlashdata('review_success', 'Review deleted successfully');
        } else {
            session()->setFlashdata('review_error', 'Failed to delete review');
        }

        return redirect()->back();
    }
}
