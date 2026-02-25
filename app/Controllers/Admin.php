<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        $session = session();

        $db = \Config\Database::connect();

        // Stats fetching
        $total_revenue = $db->table('orders')
            ->selectSum('total_amount')
            ->where('status', 'completed')
            ->get()
            ->getRow()->total_amount ?? 0;

        $total_orders = $db->table('orders')->countAllResults();
        
        $total_customers = $db->table('users')
            ->where('role', 'customer')
            ->countAllResults();

        $total_products = $db->table('products')->countAllResults();

        // Products for the Menu view
        $products = $db->table('products')->get()->getResult();

        // Recent orders
        $recent_orders = $db->table('orders')
            ->select('orders.*, users.username as customer_name')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // Current admin info (handle null session gracefully)
        $userId = $session->get('user_id');
        $user = null;
        if ($userId) {
            $user = $db->table('users')
                ->where('id', $userId)
                ->get()
                ->getRow();
        }

        // Mock a user object if not logged in
        if (!$user) {
            $user = (object)[
                'username' => 'Administrator'
            ];
        }

        // Unique categories count
        $total_categories = $db->table('products')
            ->select('category')
            ->distinct()
            ->countAllResults();

        return view('admin/dashboard', [
            'total_revenue' => $total_revenue,
            'total_orders' => $total_orders,
            'total_customers' => $total_customers,
            'total_products' => $total_products,
            'total_categories' => $total_categories,
            'products' => $products,
            'recent_orders' => $recent_orders,
            'user' => $user
        ]);
    }

    public function products()
    {
        $session = session();
        $db = \Config\Database::connect();
        $products = $db->table('products')->get()->getResult();
        
        // Fetch categories for filtering (demo)
        $categories = $db->table('products')->select('category')->distinct()->get()->getResult();

        // Admin info
        $user = $db->table('users')->where('id', $session->get('user_id'))->get()->getRow();

        return view('admin/products/index', [
            'products' => $products,
            'categories' => $categories,
            'user' => $user
        ]);
    }

    public function orders()
    {
        $session = session();
        $db = \Config\Database::connect();
        $orders = $db->table('orders')
            ->select('orders.*, users.username as customer_name')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        // Admin info
        $user = $db->table('users')->where('id', $session->get('user_id'))->get()->getRow();

        return view('admin/orders', [
            'orders' => $orders,
            'user' => $user
        ]);
    }

    public function categories()
    {
        $session = session();
        $db = \Config\Database::connect();
        $categories = $db->table('products')
            ->select('category, COUNT(*) as product_count')
            ->groupBy('category')
            ->get()
            ->getResult();

        // Admin info
        $user = $db->table('users')->where('id', $session->get('user_id'))->get()->getRow();

        return view('admin/categories', [
            'categories' => $categories,
            'user' => $user
        ]);
    }


    public function deleteUser($id)
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        $db = \Config\Database::connect();
        $db->table('users')->delete(['id' => $id]);
        return redirect()->to(site_url('admin/dashboard'))->with('success', 'User deleted');
    }

    // --- Product Management ---

    public function addProduct()
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        return view('admin/products/add');
    }

    public function storeProduct()
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        $db = \Config\Database::connect();

        $name = $this->request->getPost('product_name');
        $data = [
            'product_name' => $name,
            'slug'         => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))),
            'description'  => $this->request->getPost('description'),
            'price'        => $this->request->getPost('price'),
            'category'     => $this->request->getPost('category'),
            'status'       => $this->request->getPost('status') ?? 'available',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        // Handle Image Upload
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('images/', $newName);
            $data['image_url'] = 'images/' . $newName;
        }

        $db->table('products')->insert($data);
        return redirect()->to(site_url('admin/dashboard'))->with('success', 'Product added successfully');
    }

    public function editProduct($id)
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        $db = \Config\Database::connect();
        $product = $db->table('products')->where('id', $id)->get()->getRow();
        return view('admin/products/edit', ['product' => $product]);
    }

    public function updateProduct($id)
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        $db = \Config\Database::connect();

        $name = $this->request->getPost('product_name');
        $data = [
            'product_name' => $name,
            'slug'         => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))),
            'description'  => $this->request->getPost('description'),
            'price'        => $this->request->getPost('price'),
            'category'     => $this->request->getPost('category'),
            'status'       => $this->request->getPost('status'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('images/', $newName);
            $data['image_url'] = 'images/' . $newName;
        }

        $db->table('products')->where('id', $id)->update($data);
        return redirect()->to(site_url('admin/dashboard'))->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        $db = \Config\Database::connect();
        $db->table('products')->delete(['id' => $id]);
        return redirect()->to(site_url('admin/dashboard'))->with('success', 'Product deleted');
    }

    // --- Order Management ---

    public function updateOrderStatus()
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        $id = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');
        
        $db = \Config\Database::connect();
        $db->table('orders')->where('id', $id)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        
        return redirect()->to(site_url('admin/dashboard'))->with('success', 'Order #' . $id . ' updated to ' . $status);
    }
} // <-- make sure this closing bracket exists
