<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_number',
        'account_name',
        'npwp_trems',
        'address',
        'ubis',
        'bisnis_area',
        'business_share',
        'divisi',
        'witel',
    ];
}
