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
        Schema::create('chemical_orders', function (Blueprint $table) {
            $table->id();
            $table->string('details'); // Chemical name or details
            $table->string('supplier_name'); // Supplier of the chemical
            $table->integer('quantity'); // Quantity ordered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('chemical_orders');
    }
};
