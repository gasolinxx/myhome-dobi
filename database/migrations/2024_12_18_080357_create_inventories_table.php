<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_number')->unique();
            $table->string('name');
            $table->text('details')->nullable();
            $table->integer('current_stock')->default(0);
            $table->integer('max_stock')->default(0);
            $table->string('unit')->nullable(); // e.g., 'kg', 'liters'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
