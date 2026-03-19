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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'return_request', 'cancelled', 'refunded'])
                ->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->enum('payment_method', ['cod', 'stripe'])->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);

            // Amounts
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // Shipping info
            $table->string('shipping_method')->default('standard')->nullable(); // "Standard" or "Express"
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('zip', 20)->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
