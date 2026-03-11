<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExpandedProductSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            // ─── COLD BREW ───
            [
                'product_name' => 'Classic Cold Brew',
                'slug'         => 'classic-cold-brew',
                'description'  => 'Smooth and bold cold-brewed coffee steeped for 24 hours for a naturally sweet, low-acid flavor.',
                'price'        => 130.00,
                'category'     => 'Cold Brew',
                'image_url'    => 'images/classic_cold_brew.png',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Nitro Cold Brew',
                'slug'         => 'nitro-cold-brew',
                'description'  => 'Cold brew infused with nitrogen for a creamy, velvety texture and cascading bubbles.',
                'price'        => 160.00,
                'category'     => 'Cold Brew',
                'image_url'    => 'images/nitro_cold_brew.png',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Vanilla Sweet Cream Cold Brew',
                'slug'         => 'vanilla-sweet-cream-cold-brew',
                'description'  => 'Cold brew topped with a silky vanilla sweet cream, perfectly balanced.',
                'price'        => 175.00,
                'category'     => 'Cold Brew',
                'image_url'    => 'images/vanilla_sweet_cream_cold_brew.png',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Brown Sugar Cold Brew',
                'slug'         => 'brown-sugar-cold-brew',
                'description'  => 'Our classic cold brew sweetened with rich brown sugar syrup and a splash of oat milk.',
                'price'        => 165.00,
                'category'     => 'Cold Brew',
                'image_url'    => 'images/brown_sugar_cold_brew.png',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Iced Americano',
                'slug'         => 'iced-americano',
                'description'  => 'Espresso shots topped with cold water and ice for a clean, crisp coffee experience.',
                'price'        => 110.00,
                'category'     => 'Cold Brew',
                'image_url'    => 'images/iced_americano_new.png',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            // ─── ESPRESSO ───
            [
                'product_name' => 'Classic Espresso',
                'slug'         => 'classic-espresso',
                'description'  => 'Rich and intense single shot of pure espresso, the foundation of all great coffee.',
                'price'        => 90.00,
                'category'     => 'Espresso',
                'image_url'    => 'images/classic_espresso.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Double Espresso',
                'slug'         => 'double-espresso',
                'description'  => 'A concentrated double shot for extra energy and a deeper, bolder flavor.',
                'price'        => 120.00,
                'category'     => 'Espresso',
                'image_url'    => 'images/double_espresso.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Ristretto',
                'slug'         => 'ristretto',
                'description'  => 'A shorter, more concentrated espresso pull — sweeter and less bitter than a standard shot.',
                'price'        => 100.00,
                'category'     => 'Espresso',
                'image_url'    => 'images/ristretto.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Macchiato',
                'slug'         => 'macchiato',
                'description'  => 'A bold espresso shot stained with a dollop of velvety steamed milk foam.',
                'price'        => 115.00,
                'category'     => 'Espresso',
                'image_url'    => 'images/macchiato.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Americano',
                'slug'         => 'americano',
                'description'  => 'Espresso diluted with hot water for a smooth, full-bodied coffee experience.',
                'price'        => 105.00,
                'category'     => 'Espresso',
                'image_url'    => 'images/americano_hot.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            // ─── MILK BASED ───
            [
                'product_name' => 'Cappuccino',
                'slug'         => 'cappuccino',
                'description'  => 'Classic espresso with an equal ratio of steamed milk and rich, airy foam.',
                'price'        => 140.00,
                'category'     => 'Milk Based',
                'image_url'    => 'images/cappuccino.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Caramel Latte',
                'slug'         => 'caramel-latte',
                'description'  => 'Smooth espresso mixed with caramel syrup, steamed milk, and whipped cream.',
                'price'        => 155.00,
                'category'     => 'Milk Based',
                'image_url'    => 'images/caramel_latte.png',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Flat White',
                'slug'         => 'flat-white',
                'description'  => 'A velvety flat white with silky micro-foam poured over a ristretto shot.',
                'price'        => 145.00,
                'category'     => 'Milk Based',
                'image_url'    => 'images/cappuccino.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Matcha Latte',
                'slug'         => 'matcha-latte',
                'description'  => 'Premium ceremonial-grade matcha whisked with steamed oat milk. Earthy, creamy, and perfectly balanced.',
                'price'        => 165.00,
                'category'     => 'Milk Based',
                'image_url'    => 'images/caramel_latte.png',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Hot Chocolate',
                'slug'         => 'hot-chocolate',
                'description'  => 'Rich, velvety Belgian chocolate blended with steamed milk for the ultimate comfort drink.',
                'price'        => 135.00,
                'category'     => 'Milk Based',
                'image_url'    => 'images/cappuccino.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            // ─── PASTRIES ───
            [
                'product_name' => 'Blueberry Muffin',
                'slug'         => 'blueberry-muffin',
                'description'  => 'Freshly baked golden muffin bursting with real blueberries. Soft inside, gently crisp on top.',
                'price'        => 85.00,
                'category'     => 'Pastries',
                'image_url'    => 'images/blueberrymuffin.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Butter Croissant',
                'slug'         => 'butter-croissant',
                'description'  => 'Golden, flaky, made-from-scratch croissant with layers of pure butter. A Parisian classic.',
                'price'        => 95.00,
                'category'     => 'Pastries',
                'image_url'    => 'images/blueberrymuffin.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Chocolate Muffin',
                'slug'         => 'chocolate-muffin',
                'description'  => 'Decadent dark chocolate muffin loaded with chocolate chips. A chocolate lovers dream.',
                'price'        => 90.00,
                'category'     => 'Pastries',
                'image_url'    => 'images/blueberrymuffin.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Cinnamon Roll',
                'slug'         => 'cinnamon-roll',
                'description'  => 'Pillowy-soft roll swirled with cinnamon sugar and topped with a creamy vanilla glaze.',
                'price'        => 105.00,
                'category'     => 'Pastries',
                'image_url'    => 'images/blueberrymuffin.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_name' => 'Banana Bread',
                'slug'         => 'banana-bread',
                'description'  => 'Moist, dense banana bread made with ripe bananas, walnuts, and a hint of vanilla.',
                'price'        => 80.00,
                'category'     => 'Pastries',
                'image_url'    => 'images/blueberrymuffin.jpg',
                'status'       => 'available',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];

        // Insert each product only if slug does not already exist
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

        echo "\nDone expanding the product catalog.\n";
    }
}
