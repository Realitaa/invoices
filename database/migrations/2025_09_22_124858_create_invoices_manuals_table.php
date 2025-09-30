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
        Schema::create('invoice_manual', function (Blueprint $table) {
            $table->id();
            $table->string('idnumber')->nullable();
            $table->string('nama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_tagihan')->nullable();
            $table->string('npwp')->nullable();
            $table->integer('tahun_tagihan')->nullable();
            $table->tinyInteger('bulan_tagihan')->nullable();
            $table->date('tanggal_akhir_pembayaran')->nullable();
            $table->enum('tipe_invoice_manual', ['PROSES AOSODOMORO', 'RENEWAL KONTRAK', 'ADJUSTMENT', 'BUNDLING', 'BY REKON/USAGE'])->nullable();
            $table->text('keterangan_invoice_manual')->nullable();
            $table->string('nomor_order')->nullable();
            $table->string('status_order_terakhir')->nullable();
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
