<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceManualSubproduct extends Model
{
    protected $fillable = [
        'invoice_manual_product_id',
        'subproduct_sid',
        'subproduct_desc',
        'subproduct_bw',
        'subproduct_period',
        'subproduct_amount',
    ];

    public function product()
    {
        return $this->belongsTo(InvoiceManualProduct::class, 'invoice_manual_product_id');
    }
}
