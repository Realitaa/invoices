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
        Schema::create('invoice_manual_subproducts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_manual_product_id')->constrained('invoice_manual_products')->onDelete('cascade');
            $table->string('subproduct_sid')->nullable();
            $table->string('subproduct_desc')->nullable();
            $table->string('subproduct_bw')->nullable();
            $table->string('subproduct_period')->nullable();
            $table->string('subproduct_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_manual_subproducts');
    }
};
