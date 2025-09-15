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
            $table->string('account_id');
            $table->string('npwp');
            $table->integer('amount');
            $table->string('reason');
            $table->boolean('payment');
            $table->boolean('flagging');
            $table->text('note')->nullable();
            $table->date('due_date');
            $table->enum('accepted_invoice', ['Sudah', 'Belum', 'Cancel']);
            $table->text('delayed_paying_reason')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
