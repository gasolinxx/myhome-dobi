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
        Schema::create('laundry_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name'); // Wash & Fold, Iron, etc.
            $table->foreignId('laundry_type_id')->constrained()->onDelete('cascade'); // Associate service with a type
            $table->decimal('price', 8, 2); // Store price for each service
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_services');
    }
};
