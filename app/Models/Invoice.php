<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'customer_id',
        'reason',
        'payment_status',
        'year_periode',
        'month_periode',
        'due_date',
        'accepted_invoice',
        'delayed_paying_reason',
    ];

    protected $casts = [
        'payment_status' => 'boolean',
        'due_date' => 'date',
        'accepted_invoice' => 'string',
    ];
}
