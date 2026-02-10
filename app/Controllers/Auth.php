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
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => md5($this->request->getPost('password')), // keep MD5 for customers
            'role' => 'customer'
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

        // Get user by email only
        $user = $db->table('users')
            ->where('email', $email)
            ->get()
            ->getRow();

        if ($user) {
            $valid = false;

            // Check password type
            if (strlen($user->password) == 32) { // MD5 for old customers
                $valid = md5($passwordInput) === $user->password;
            } else { // bcrypt for admin or new users
                $valid = password_verify($passwordInput, $user->password);
            }

            if ($valid) {
                $session = session();
                $session->set([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'logged_in' => true
                ]);

                $session->setFlashdata('login_success', 'Login successful! Welcome back, ' . $user->username . '.');

                if ($user->role == 'admin') {
                    $redirectUrl = '/admin/dashboard';
                } else {
                    $redirectUrl = '/customer/dashboard';
                }

                return view('auth/login', [
                    'login_success' => true,
                    'redirect_url' => $redirectUrl,
                    'user_name' => $user->username
                ]);
            }
        }

        return view('auth/login', ['error' => 'Invalid email or password']);
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Logged out successfully');
        return redirect()->to('/login');
    }
}
