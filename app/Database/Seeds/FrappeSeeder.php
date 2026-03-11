<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FrappeSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'product_name' => 'Classic Coffee Frappe',
                'slug'         => 'classic-coffee-frappe',
                'description'  => 'Rich blended espresso with milk and ice, topped with whipped cream. The ultimate frozen coffee treat.',
                'price'        => 155.00,
                'category'     => 'Frappe',
                'image_url'    => 'images/classiccofeefrappe.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Caramel Frappe',
                'slug'         => 'caramel-frappe',
                'description'  => 'A dreamy blend of espresso, caramel syrup, milk, and ice finished with caramel drizzle and whipped cream.',
                'price'        => 170.00,
                'category'     => 'Frappe',
                'image_url'    => 'images/caramelfrappe.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Mocha Frappe',
                'slug'         => 'mocha-frappe',
                'description'  => 'Espresso blended with rich chocolate sauce, milk, and ice — topped with chocolate drizzle and cream.',
                'price'        => 175.00,
                'category'     => 'Frappe',
                'image_url'    => 'images/mochafrappe.webp',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Matcha Frappe',
                'slug'         => 'matcha-frappe',
                'description'  => 'Premium matcha blended with milk and ice for a refreshing, earthy, and creamy frozen drink.',
                'price'        => 175.00,
                'category'     => 'Frappe',
                'image_url'    => 'images/matchafrappe.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Vanilla Frappe',
                'slug'         => 'vanilla-frappe',
                'description'  => 'A smooth, creamy vanilla frappe made with real vanilla bean, blended with milk and ice.',
                'price'        => 160.00,
                'category'     => 'Frappe',
                'image_url'    => 'images/vanillafrappe.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];

        foreach ($data as $product) {
            $exists = $this->db->table('products')
                ->where('slug', $product['slug'])
                ->countAllResults();

            if (!$exists) {
                $this->db->table('products')->insert($product);
                echo "  Added: {$product['product_name']}\n";
            } else {
                echo "  Skipped (already exists): {$product['product_name']}\n";
            }
        }

        echo "\nFrappe products seeded successfully!\n";
    }
}
