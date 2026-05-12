// database/migrations/xxxx_create_products_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('slug')->unique();  // UN SEUL slug !
            $table->string('sku')->nullable();  // UN SEUL slug !
            $table->json('name');              // Spatie gère le JSON automatiquement
            $table->json('description');       // Spatie gère le JSON automatiquement
            $table->decimal('prix_original', 10, 2)->nullable();
            $table->decimal('prix_actuel', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};