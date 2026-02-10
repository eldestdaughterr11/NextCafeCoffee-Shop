<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'created_at'];
    protected $useTimestamps = false;
    protected $returnType = 'object'; // Changed from array to object
    protected $createdField = 'created_at';

    /**
     * Get all wishlist items for a user with product details
     */
    public function getUserWishlist($userId)
    {
        return $this->select('wishlist.*, products.product_name, products.slug, products.price, products.image_url, products.category, products.status')
            ->join('products', 'products.id = wishlist.product_id')
            ->where('wishlist.user_id', $userId)
            ->orderBy('wishlist.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Check if product is in user's wishlist
     */
    public function isInWishlist($userId, $productId)
    {
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first() !== null;
    }

    /**
     * Add product to wishlist
     */
    public function addToWishlist($userId, $productId)
    {
        // Check if already exists
        if ($this->isInWishlist($userId, $productId)) {
            return false; // Already in wishlist
        }

        $data = [
            'user_id' => $userId,
            'product_id' => $productId,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->insert($data);
    }

    /**
     * Remove product from wishlist
     */
    public function removeFromWishlist($userId, $productId)
    {
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    /**
     * Get wishlist count for a user
     */
    public function getWishlistCount($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    /**
     * Clear all wishlist items for a user
     */
    public function clearWishlist($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}
