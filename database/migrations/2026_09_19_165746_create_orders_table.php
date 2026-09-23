<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('number')->unique();          // человекочитаемый номер заказа
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending_payment');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('unpaid'); // unpaid / paid / refunded
            $table->string('payment_ref')->nullable();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('delivery_address');
            $table->text('comment')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
