<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CoffeeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product_name' => 'Classic Espresso',
                'slug'         => 'classic-espresso',
                'description'  => 'Rich and intense shot of pure coffee.',
                'price'         => 90.00,
                'category'      => 'Espresso',
                'image_url'     => 'images/espresso.jpg',
                'status'        => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'product_name' => 'Double Espresso',
                'slug'         => 'double-espresso',
                'description'  => 'A concentrated double shot for extra energy.',
                'price'         => 120.00,
                'category'      => 'Espresso',
                'image_url'     => 'images/espresso.jpg',
                'status'        => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'product_name' => 'Cappuccino',
                'slug'         => 'cappuccino',
                'description'  => 'Espresso with steamed milk and a deep layer of foam.',
                'price'         => 140.00,
                'category'      => 'Milk Based',
                'image_url'     => 'images/cappuccino.jpg',
                'status'        => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'product_name' => 'Caramel Latte',
                'slug'         => 'caramel-latte',
                'description'  => 'Smooth espresso mixed with caramel syrup and steamed milk.',
                'price'         => 155.00,
                'category'      => 'Milk Based',
                'image_url'     => 'images/latte.jpg',
                'status'        => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'product_name' => 'Iced Americano',
                'slug'         => 'iced-americano',
                'description'  => 'Espresso shots topped with cold water and ice.',
                'price'         => 110.00,
                'category'      => 'Cold Brew',
                'image_url'     => 'images/americano.jpg',
                'status'        => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'product_name' => 'Blueberry Muffin',
                'slug'         => 'blueberry-muffin',
                'description'  => 'Freshly baked muffin with real blueberries.',
                'price'         => 85.00,
                'category'      => 'Pastries',
                'image_url'     => 'images/blueberrymuffin.jpg',
                'status'        => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert batch
        $this->db->table('products')->insertBatch($data);
    }
}
