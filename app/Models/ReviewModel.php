<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'rating', 'review_text', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'product_id' => 'required|integer',
        'rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'review_text' => 'permit_empty|min_length[3]|max_length[500]'
    ];

    /**
     * Get all reviews for a specific product
     */
    public function getProductReviews($productId)
    {
        return $this->select('reviews.*, users.name as user_name, users.username')
            ->join('users', 'users.id = reviews.user_id')
            ->where('reviews.product_id', $productId)
            ->orderBy('reviews.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get average rating for a product
     */
    public function getAverageRating($productId)
    {
        $result = $this->selectAvg('rating', 'avg_rating')
            ->selectCount('id', 'review_count')
            ->where('product_id', $productId)
            ->first();

        return [
            'average' => $result['avg_rating'] ? round($result['avg_rating'], 1) : 0,
            'count' => $result['review_count'] ?? 0
        ];
    }

    /**
     * Check if user has purchased the product
     */
    public function hasUserPurchased($userId, $productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('order_items');
        
        $result = $builder->select('order_items.id')
            ->join('orders', 'orders.id = order_items.order_id')
            ->where('orders.user_id', $userId)
            ->where('order_items.product_id', $productId)
            ->where('orders.status', 'completed')
            ->get()
            ->getRow();

        return $result !== null;
    }

    /**
     * Check if user has already reviewed the product
     */
    public function hasUserReviewed($userId, $productId)
    {
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first() !== null;
    }

    /**
     * Get user's review for a product
     */
    public function getUserReview($userId, $productId)
    {
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * Delete a review (only if it belongs to the user)
     */
    public function deleteUserReview($reviewId, $userId)
    {
        return $this->where('id', $reviewId)
            ->where('user_id', $userId)
            ->delete();
    }
}
