<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Admin User',
                'username'   => 'admin',
                'email'      => 'admin@example.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'picture'    => 'default.png',
                'bio'        => 'I am the administrator.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'John Doe',
                'username'   => 'johndoe',
                'email'      => 'john@example.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'picture'    => 'default.png',
                'bio'        => 'Regular user.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Insert batch
        $this->db->table('users')->insertBatch($data);
    }
}
