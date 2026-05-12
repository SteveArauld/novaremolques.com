<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug'];

    public array $translatable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}