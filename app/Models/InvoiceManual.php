<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceManual extends Model
{
    protected $fillable = [
        'idnumber',
        'nama',
        'alamat',
        'nomor_tagihan',
        'npwp',
        'tahun_tagihan',
        'bulan_tagihan',
        'tanggal_akhir_pembayaran',
        'tipe_invoice_manual',
        "keterangan_invoice_manual",
        "nomor_order",
        "status_order_terakhir",
        "tanggal_komitmen_penyelesaian",
    ];

    protected $casts = [
        'tipe_invoice_manual' => 'string',
        'tanggal_akhir_pembayaran' => 'date',
        'status_order_terakhir' => 'string',
    ];

    /**
     * Get the products for the invoice.
     */
    public function products()
    {
        return $this->hasMany(InvoiceManualProduct::class);
    }
}
