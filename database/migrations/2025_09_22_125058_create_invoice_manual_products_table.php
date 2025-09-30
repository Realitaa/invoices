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
        Schema::create('invoice_manual_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_manual_id')->constrained('invoice_manuals')->onDelete('cascade');
            $table->string('product_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_reason');
    }
};
