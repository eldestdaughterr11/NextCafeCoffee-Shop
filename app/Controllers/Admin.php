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
        
        $builder = $db->table('products');

        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $status = $this->request->getGet('status');

        if (empty($sort)) $sort = 'created_at';
        if (empty($order)) $order = 'DESC';

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('product_name', $search)
                    ->orLike('description', $search)
                    ->groupEnd();
        }

        if (!empty($category)) {
            $builder->where('category', $category);
        }

        if (!empty($status)) {
            $builder->where('status', $status);
        }

        $builder->orderBy($sort, $order);
        $products = $builder->get()->getResult();
        
        // Fetch categories for filtering from the categories table
        $categories = $db->table('categories')->orderBy('name')->get()->getResult();

        // Admin info
        $userId = $session->get('user_id');
        $user = null;
        if ($userId) {
            $user = $db->table('users')->where('id', $userId)->get()->getRow();
        }

        if (!$user) {
            $user = (object)['username' => 'Administrator'];
        }

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
        // Admin info
        $userId = $session->get('user_id');
        $user = null;
        if ($userId) {
            $user = $db->table('users')->where('id', $userId)->get()->getRow();
        }

        if (!$user) {
            $user = (object)['username' => 'Administrator'];
        }


        return view('admin/orders', [
            'orders' => $orders,
            'user' => $user
        ]);
    }

    public function orderDetail($id)
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $order = $db->table('orders')
            ->select('orders.*, users.username as customer_name')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.id', $id)
            ->get()
            ->getRow();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Order not found");
        }

        $items = $db->table('order_items')
            ->select('order_items.*, products.product_name, products.image_url')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->where('order_id', $id)
            ->get()
            ->getResult();

        $userId = $session->get('user_id');
        $user = $userId ? $db->table('users')->where('id', $userId)->get()->getRow() : (object)['username' => 'Administrator'];

        return view('admin/order_detail', [
            'order' => $order,
            'items' => $items,
            'user' => $user
        ]);
    }

    public function categories()
    {
        $session = session();
        $db = \Config\Database::connect();
        $builder = $db->table('categories');

        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');

        if (empty($sort)) $sort = 'name';
        if (empty($order)) $order = 'ASC';

        if (!empty($search)) {
            $builder->like('name', $search);
        }
        if (!empty($status)) {
            $builder->where('status', $status);
        }

        $builder->orderBy($sort, $order);
        $categories = $builder->get()->getResult();

        // Admin info
        // Admin info
        $userId = $session->get('user_id');
        $user = null;
        if ($userId) {
            $user = $db->table('users')->where('id', $userId)->get()->getRow();
        }

        if (!$user) {
            $user = (object)['username' => 'Administrator'];
        }


        // Fetch categories list for dropdown
        $categoriesList = $db->table('categories')->select('name')->get()->getResult();

        return view('admin/categories/index', [
            'categories' => $categories,
            'categoriesList' => $categoriesList,
            'user' => $user
        ]);
    }


    public function deleteUser($id)
    {
        $db = \Config\Database::connect();
        // Safety guard: never allow deletion of admin accounts
        $target = $db->table('users')->where('id', $id)->get()->getRow();
        if (!$target || $target->role === 'admin') {
            return redirect()->to(site_url('admin/users'))->with('error', 'Admin accounts cannot be deleted.');
        }
        $db->table('users')->delete(['id' => $id]);
        return redirect()->to(site_url('admin/users'))->with('success', 'User deleted successfully.');
    }

    public function users()
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $builder = $db->table('users');
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $role = $this->request->getGet('role');
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        
        if (empty($sort)) $sort = 'created_at';
        if (empty($order)) $order = 'DESC';

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('name', $search)
                    ->orLike('email', $search)
                    ->orLike('username', $search)
                    ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('status', $status);
        }

        if (!empty($role)) {
            $builder->where('role', $role);
        }

        $builder->orderBy($sort, $order);
        $usersList = $builder->get()->getResult();

        $userId = $session->get('user_id');
        $user = null;
        if ($userId) {
            $user = $db->table('users')->where('id', $userId)->get()->getRow();
        }

        if (!$user) {
            $user = (object)['username' => 'Administrator'];
        }

        return view('admin/users/index', [
            'usersList' => $usersList,
            'user' => $user
        ]);
    }

    public function editUser($id)
    {
        $db = \Config\Database::connect();
        $editUser = $db->table('users')->where('id', $id)->get()->getRow();
        return view('admin/users/edit', ['editUser' => $editUser]);
    }

    public function updateUser($id)
    {
        $db = \Config\Database::connect();
        $data = [
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $db->table('users')->where('id', $id)->update($data);
        return redirect()->to(site_url('admin/users'))->with('success', 'User updated successfully');
    }

    public function toggleUserStatus($id)
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $id)->get()->getRow();
        if ($user) {
            $newStatus = ($user->status === 'active') ? 'inactive' : 'active';
            $db->table('users')->where('id', $id)->update(['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')]);
            return redirect()->to(site_url('admin/users'))->with('success', 'User status updated to ' . $newStatus);
        }
        return redirect()->to(site_url('admin/users'))->with('error', 'User not found');
    }

    // --- Category Management ---

    public function addCategory()
    {
        return view('admin/categories/add');
    }

    public function storeCategory()
    {
        $db = \Config\Database::connect();
        $name = $this->request->getPost('name');
        $data = [
            'name' => $name,
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))),
            'status' => $this->request->getPost('status') ?? 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $db->table('categories')->insert($data);
        return redirect()->to(site_url('admin/categories'))->with('success', 'Category added successfully');
    }

    public function editCategory($id)
    {
        $db = \Config\Database::connect();
        $category = $db->table('categories')->where('id', $id)->get()->getRow();
        return view('admin/categories/edit', ['category' => $category]);
    }

    public function updateCategory($id)
    {
        $db = \Config\Database::connect();
        $category = $db->table('categories')->where('id', $id)->get()->getRow();
        if (!$category) {
            return redirect()->to(site_url('admin/categories'))->with('error', 'Category not found');
        }
        
        $oldName = $category->name;
        $name = $this->request->getPost('name');
        
        $data = [
            'name' => $name,
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))),
            'status' => $this->request->getPost('status') ?? 'active',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $db->table('categories')->where('id', $id)->update($data);
        
        // Cascade the name update to products if the category name changed
        if ($oldName !== $name) {
            $db->table('products')->where('category', $oldName)->update(['category' => $name]);
        }
        
        return redirect()->to(site_url('admin/categories'))->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        $db = \Config\Database::connect();
        $db->table('categories')->delete(['id' => $id]);
        return redirect()->to(site_url('admin/categories'))->with('success', 'Category deleted');
    }

    public function toggleCategoryStatus($id)
    {
        $db = \Config\Database::connect();
        $category = $db->table('categories')->where('id', $id)->get()->getRow();
        if ($category) {
            $newStatus = ($category->status === 'active') ? 'inactive' : 'active';
            $db->table('categories')->where('id', $id)->update(['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')]);
            return redirect()->to(site_url('admin/categories'))->with('success', 'Category status updated to ' . $newStatus);
        }
        return redirect()->to(site_url('admin/categories'))->with('error', 'Category not found');
    }

    // --- Product Management ---

    public function addProduct()
    {
        $db = \Config\Database::connect();
        $categories = $db->table('categories')->where('status', 'active')->orderBy('name')->get()->getResult();
        
        return view('admin/products/add', ['categories' => $categories]);
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
        $db = \Config\Database::connect();
        $product = $db->table('products')->where('id', $id)->get()->getRow();
        $categories = $db->table('categories')->where('status', 'active')->orderBy('name')->get()->getResult();
        
        return view('admin/products/edit', [
            'product' => $product,
            'categories' => $categories
        ]);
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
        $db = \Config\Database::connect();
        $db->table('products')->delete(['id' => $id]);
        return redirect()->to(site_url('admin/products'))->with('success', 'Product deleted successfully.');
    }

    public function toggleProductStatus($id)
    {
        $db = \Config\Database::connect();
        $product = $db->table('products')->where('id', $id)->get()->getRow();
        if ($product) {
            $newStatus = ($product->status === 'available') ? 'unavailable' : 'available';
            $db->table('products')->where('id', $id)->update(['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')]);
            return redirect()->to(site_url('admin/products'))->with('success', 'Product status updated to ' . $newStatus);
        }
        return redirect()->to(site_url('admin/products'))->with('error', 'Product not found');
    }

    // --- Order Management ---

    public function updateOrderStatus()
    {
        // if (!session()->get('logged_in') || session()->get('role') != 'admin') return redirect()->to(site_url('login'));
        $id = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');
        
        $db = \Config\Database::connect();
        $db->table('orders')->where('id', $id)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        
        return redirect()->to(site_url('admin/orders'))->with('success', 'Order #' . $id . ' updated to ' . $status);
    }

    public function deleteOrder($id)
    {
        $db = \Config\Database::connect();
        // Also delete associated order items
        $db->table('order_items')->delete(['order_id' => $id]);
        $db->table('orders')->delete(['id' => $id]);
        return redirect()->to(site_url('admin/orders'))->with('success', 'Order #' . $id . ' deleted successfully.');
    }
} // <-- make sure this closing bracket exists
