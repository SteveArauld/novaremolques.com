<?php
// database/migrations/2024_01_01_000000_create_reviews_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('author_name');
            $table->string('author_email');
            $table->integer('rating')->comment('Note de 1 à 5');
            $table->text('comment');
            $table->string('author_country')->nullable();
            $table->string('author_photo')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('product_id');
            $table->index('rating');
            $table->index('is_approved');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}