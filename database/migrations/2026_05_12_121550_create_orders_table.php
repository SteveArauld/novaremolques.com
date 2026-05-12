<?php
// database/migrations/2024_01_01_000001_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Numéro de commande
            $table->string('order_number')->unique();
            
            // Statut
            $table->string('status')->default('pending');
            $table->string('payment_method')->default('transfer');
            $table->string('payment_status')->default('pending');
            
            // Montants
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Code promo
            $table->string('coupon_code')->nullable();
            
            // Facturation
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_company')->nullable();
            $table->string('billing_country');
            $table->text('billing_address_1');
            $table->text('billing_address_2')->nullable();
            $table->string('billing_city');
            $table->string('billing_state')->nullable();
            $table->string('billing_postcode');
            $table->string('billing_phone');
            $table->string('billing_email');
            
            // Livraison
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->text('shipping_address_1')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_country')->nullable();
            
            // Produits (stockés en JSON)
            $table->json('items');
            
            // Notes
            $table->text('notes')->nullable();
            
            // Métadonnées
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}