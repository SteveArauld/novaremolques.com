<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'url',
        'slug',
        'name',
        'description',
        'prix_original',
        'prix_actuel',
        'sku'
    ];

    public array $translatable = ['name', 'description'];

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getCategoryAttribute()
    {
        return $this->categories()->first();
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Ajoutez ces méthodes dans la classe Product
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->approved()->count();
    }

    public function getApprovedReviews()
    {
        return $this->reviews()->approved()->orderBy('created_at', 'desc');
    }
}
