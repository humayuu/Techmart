<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('product_name');
            $table->string('product_slug')->unique();
            $table->string('product_code')->unique();
            $table->integer('product_qty')->default(0);
            $table->string('product_tags')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('product_thumbnail');
            $table->text('product_multiple_image')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('special_offer')->default(false);
            $table->string('product_weight')->nullable();
            $table->text('other_info')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
