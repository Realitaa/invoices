<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceManualProduct extends Model
{
    protected $fillable = [
        'invoice_manual_id',
        'product_name',
    ];

    public function invoiceManual()
    {
        return $this->belongsTo(InvoiceManual::class);
    }

    public function subproducts()
    {
        return $this->hasMany(InvoiceManualSubproduct::class);
    }
}
