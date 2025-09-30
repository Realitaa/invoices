<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceManualProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'manual_invoice_reason',
        'order_number',
        'last_status',
        'commitment',
    ];
}
