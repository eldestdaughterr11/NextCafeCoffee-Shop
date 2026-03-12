<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $helpers = ['form'];

    public function register()
    {
        return view('auth/register');
    }

    public function registerSubmit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => [
                'rules' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username is required',
                    'min_length' => 'Username must be at least 3 characters',
                    'is_unique' => 'Username already exists'
                ]
            ],
            'fullname' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Full Name is required',
                    'min_length' => 'Full Name must be at least 3 characters'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email',
                    'is_unique' => 'Email already registered'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 6 characters'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Passwords do not match'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('auth/register', ['validation' => $validation]);
        }

        $db = \Config\Database::connect();
        $data = [
            'name' => $this->request->getPost('fullname'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => md5($this->request->getPost('password')), // keep MD5 for customers
            'role' => 'customer',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $db->table('users')->insert($data);

        session()->setFlashdata('success', 'Registration successful! Please login.');
        return redirect()->to('/login');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginSubmit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('auth/login', ['validation' => $validation]);
        }

        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        $passwordInput = $this->request->getPost('password');

        $user = $db->table('users')
            ->where('email', $email)
            ->where('role', 'customer') // Only allow customers here
            ->get()
            ->getRow();

        if ($user) {
            $valid = false;
            if (strlen($user->password) == 32) {
                $valid = md5($passwordInput) === $user->password;
            } else {
                $valid = password_verify($passwordInput, $user->password);
            }

            if ($valid) {
                $session = session();
                $session->set([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'logged_in' => true
                ]);

                $session->setFlashdata('login_success', 'Login successful! Welcome back, ' . $user->username . '.');

                return view('auth/login', [
                    'login_success' => true,
                    'redirect_url' => '/customer/dashboard',
                    'user_name' => $user->username
                ]);
            }
        }

        return view('auth/login', ['error' => 'invalid credentials please try again']);
    }

    public function adminLogin()
    {
        return view('auth/admin_login');
    }

    public function adminLoginSubmit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('auth/admin_login', ['validation' => $validation]);
        }

        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        $passwordInput = $this->request->getPost('password');

        $user = $db->table('users')
            ->where('email', $email)
            ->where('role', 'admin') // Only allow admins here
            ->get()
            ->getRow();

        if ($user) {
            if (password_verify($passwordInput, $user->password)) {
                $session = session();
                $session->set([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'logged_in' => true
                ]);

                $session->setFlashdata('login_success', 'Login successful! Welcome to Admin Panel.');

                return view('auth/admin_login', [
                    'login_success' => true,
                    'redirect_url' => '/admin/dashboard',
                    'user_name' => $user->username
                ]);
            }
        }

        return view('auth/admin_login', ['error' => 'Invalid admin credentials or access denied']);
    }

    public function logout()
    {
        $role = session()->get('role');
        session()->destroy();
        session()->setFlashdata('success', 'Logged out successfully');
        
        return $role === 'admin' ? redirect()->to('/admin/login') : redirect()->to('/login');
    }
}
