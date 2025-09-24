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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('id_number')->primary();
            $table->string('account_name');
            $table->string('npwp_trems');
            $table->text('address');
            $table->string('ubis');
            $table->string('bisnis_area');
            $table->string('business_share');
            $table->string('divisi');
            $table->string('witel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
