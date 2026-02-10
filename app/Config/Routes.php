<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginSubmit');

$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerSubmit');

$routes->get('customer/logout', 'Auth::logout');
$routes->get('customer/dashboard', 'Customer::dashboard');
$routes->get('customer/profile', 'Customer::profile');
$routes->get('customer/product/(:segment)', 'Customer::viewProduct/$1');
$routes->get('customer/coffee/(:num)', 'Customer::selectCoffee/$1');
$routes->get('customer/menu', 'Customer::menu');
$routes->get('customer/cart', 'Customer::cart');
$routes->get('customer/orders', 'Customer::orders');
$routes->get('customer/order/(:num)', 'Customer::orderDetail/$1');
$routes->get('customer/contact', 'Customer::contact');
$routes->get('customer/about', 'Customer::about');

$routes->post('customer/add_to_cart', 'Customer::add_to_cart');
$routes->post('customer/update_cart', 'Customer::update_cart');
$routes->post('customer/remove_from_cart', 'Customer::remove_from_cart');
$routes->post('customer/clear_cart', 'Customer::clear_cart');
$routes->post('customer/checkout', 'Customer::checkout');

// Wishlist routes
$routes->get('customer/wishlist', 'Customer::wishlist');
$routes->post('customer/wishlist/add', 'Customer::addToWishlist');
$routes->post('customer/wishlist/remove', 'Customer::removeFromWishlist');

// Review routes
$routes->post('customer/review/submit', 'Customer::submitReview');
$routes->post('customer/review/delete/(:num)', 'Customer::deleteReview/$1');

$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/profile', 'Admin::profile');
$routes->get('admin/delete/(:num)', 'Admin::deleteUser/$1');

// Admin Product Management
$routes->get('admin/products/add', 'Admin::addProduct');
$routes->post('admin/products/store', 'Admin::storeProduct');
$routes->get('admin/products/edit/(:num)', 'Admin::editProduct/$1');
$routes->post('admin/products/update/(:num)', 'Admin::updateProduct/$1');
$routes->get('admin/products/delete/(:num)', 'Admin::deleteProduct/$1');

// Admin Order Management
$routes->post('admin/orders/update', 'Admin::updateOrderStatus');

$routes->get('testdb', 'TestDB::index');
$routes->get('send-email', 'EmailController::send');
$routes->get('logout', 'Customer::logout');


