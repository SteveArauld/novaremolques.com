<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'author_name',
        'author_email',
        'rating',
        'comment',
        'author_country',
        'author_photo',
        'is_verified',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified' => 'boolean',
        'is_approved' => 'boolean'
    ];

    /**
     * Relation avec le produit
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope pour les avis approuvés
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope pour les avis vérifiés
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Récupère la note moyenne d'un produit
     */
    public static function getAverageRating($productId)
    {
        return self::where('product_id', $productId)
            ->approved()
            ->avg('rating') ?? 0;
    }

    /**
     * Récupère le nombre d'avis d'un produit
     */
    public static function getReviewCount($productId)
    {
        return self::where('product_id', $productId)
            ->approved()
            ->count();
    }
}