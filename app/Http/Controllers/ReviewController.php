<?php
// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Récupère les avis d'un produit
     */
    public function getProductReviews($productId)
    {
        $product = Product::findOrFail($productId);
        
        $reviews = $product->getApprovedReviews()
            ->select('id', 'product_id', 'author_name', 'rating', 'comment', 'author_country', 'author_photo', 'is_verified', 'created_at')
            ->paginate(10);
        
        $stats = [
            'average_rating' => round($product->average_rating, 1),
            'review_count' => $product->review_count,
            'rating_distribution' => $this->getRatingDistribution($productId)
        ];
        
        return response()->json([
            'success' => true,
            'data' => [
                'reviews' => $reviews,
                'stats' => $stats
            ]
        ]);
    }
    
    /**
     * Ajoute un nouvel avis
     */
    public function storeReview(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:100',
            'author_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'author_country' => 'nullable|string|max:100',
            'author_photo' => 'nullable|string|max:500'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $product = Product::findOrFail($productId);
        
        $review = $product->reviews()->create([
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'author_country' => $request->author_country,
            'author_photo' => $request->author_photo,
            'is_verified' => true,
            'is_approved' => true // Auto-approbation, vous pouvez changer si nécessaire
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Avis ajouté avec succès',
            'data' => $review
        ], 201);
    }
    
    /**
     * Récupère la distribution des notes
     */
    private function getRatingDistribution($productId)
    {
        $distribution = [];
        $total = Review::where('product_id', $productId)->approved()->count();
        
        for ($i = 5; $i >= 1; $i--) {
            $count = Review::where('product_id', $productId)
                ->approved()
                ->where('rating', $i)
                ->count();
            
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100) : 0
            ];
        }
        
        return $distribution;
    }
}