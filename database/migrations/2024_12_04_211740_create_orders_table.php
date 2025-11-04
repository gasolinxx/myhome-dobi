<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(); //registered user
            $table->foreignId('guest_id')->nullable(); //registered user
            $table->foreignId('laundry_service_id');
            $table->foreignId('laundry_type_id');
            $table->text('remark')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('delivery_fee', 10, 2)->nullable();
            $table->enum('status', ['Pending','Pickup', 'In Work', 'Pay','Delivery', 'Complete', 'Assign Delivery','Assign Pickup'])->default('Pending');
            $table->enum('order_method', ['Walk in', 'Pickup']);
            $table->boolean('delivery_option')->default(false); //0 -> not delivery, 1 -> delivery
            $table->text('address')->nullable();
            $table->dateTime('pickup_date')->nullable();
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
