<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'url', 'slug', 'name', 'description', 
        'prix_original', 'prix_actuel', 'sku'
    ];

    // Déclare quels champs sont traduisibles
    public array $translatable = ['name', 'description'];

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // AJOUTEZ CECI : Accesseur pour obtenir la première catégorie
    public function getCategoryAttribute()
    {
        return $this->categories()->first();
    }
}