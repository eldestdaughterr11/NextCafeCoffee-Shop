<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginSubmit');

$routes->get('admin/login', 'Auth::adminLogin');
$routes->post('admin/login', 'Auth::adminLoginSubmit');

$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerSubmit');

$routes->group('customer', ['filter' => 'customer_auth'], function($routes) {
    $routes->get('logout', 'Auth::logout');
    $routes->get('dashboard', 'Customer::dashboard');
    $routes->get('profile', 'Customer::profile');
    $routes->post('profile/update', 'Customer::updateProfile');
    $routes->get('product/(:segment)', 'Customer::viewProduct/$1');
    $routes->get('coffee/(:num)', 'Customer::selectCoffee/$1');
    $routes->get('menu', 'Customer::menu');
    $routes->get('cart', 'Customer::cart');
    $routes->get('orders', 'Customer::orders');
    $routes->get('order/(:num)', 'Customer::orderDetail/$1');
    $routes->get('contact', 'Customer::contact');
    $routes->get('about', 'Customer::about');

    $routes->post('add_to_cart', 'Customer::add_to_cart');
    $routes->post('update_cart', 'Customer::update_cart');
    $routes->post('remove_from_cart', 'Customer::remove_from_cart');
    $routes->post('clear_cart', 'Customer::clear_cart');
    $routes->post('checkout', 'Customer::checkout');

    // Wishlist routes
    $routes->get('wishlist', 'Customer::wishlist');
    $routes->post('wishlist/add', 'Customer::addToWishlist');
    $routes->post('wishlist/remove', 'Customer::removeFromWishlist');

    // Review routes
    $routes->post('review/submit', 'Customer::submitReview');
    $routes->post('review/delete/(:num)', 'Customer::deleteReview/$1');
});

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('products', 'Admin::products');
    $routes->get('profile', 'Admin::profile');
    
    // Admin User Management
    $routes->get('users', 'Admin::users');
    $routes->get('users/edit/(:num)', 'Admin::editUser/$1');
    $routes->post('users/update/(:num)', 'Admin::updateUser/$1');
    $routes->get('users/toggle/(:num)', 'Admin::toggleUserStatus/$1');
    $routes->get('users/delete/(:num)', 'Admin::deleteUser/$1');
    $routes->get('delete/(:num)', 'Admin::deleteUser/$1');
    
    // Admin Product Management
    $routes->get('products/add', 'Admin::addProduct');
    $routes->post('products/store', 'Admin::storeProduct');
    $routes->get('products/edit/(:num)', 'Admin::editProduct/$1');
    $routes->post('products/update/(:num)', 'Admin::updateProduct/$1');
    $routes->get('products/delete/(:num)', 'Admin::deleteProduct/$1');
    $routes->get('products/toggle/(:num)', 'Admin::toggleProductStatus/$1');
    
    // Admin Category Management
    $routes->get('categories', 'Admin::categories');
    $routes->get('categories/add', 'Admin::addCategory');
    $routes->post('categories/store', 'Admin::storeCategory');
    $routes->get('categories/edit/(:num)', 'Admin::editCategory/$1');
    $routes->post('categories/update/(:num)', 'Admin::updateCategory/$1');
    $routes->get('categories/delete/(:num)', 'Admin::deleteCategory/$1');
    $routes->get('categories/toggle/(:num)', 'Admin::toggleCategoryStatus/$1');
    
    // Admin Order Management
    $routes->get('orders', 'Admin::orders');
    $routes->get('orders/details/(:num)', 'Admin::orderDetail/$1');
    $routes->get('orders/delete/(:num)', 'Admin::deleteOrder/$1');
    $routes->post('orders/update', 'Admin::updateOrderStatus');
    
    $routes->get('logout', 'Auth::logout');
});

$routes->get('testdb', 'TestDB::index');
$routes->get('send-email', 'EmailController::send');
$routes->get('logout', 'Customer::logout');
$routes->get('fix-admin', 'FixAdmin::index');


