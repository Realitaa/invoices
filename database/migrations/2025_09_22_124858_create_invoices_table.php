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
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->enum('reason', ['PROSES AOSODOMORO', 'RENEWAL KONTRAK', 'ADJUSTMENT', 'BUNDLING', 'BY REKON/USAGE']);
            $table->boolean('payment_status');
            $table->integer('year_periode');
            $table->tinyInteger('month_periode');
            $table->date('due_date');
            $table->enum('accepted_invoice', ['Sudah', 'Belum', 'Cancel']);
            $table->text('delayed_paying_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
