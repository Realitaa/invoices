<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceManuals extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

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
}
