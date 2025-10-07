<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MInventory extends Model
{

    protected $table = 'm_inventory';
    protected $primaryKey = 'id_inventory';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_inventory',
        'category',
        'name',
        'qty',
        'unit',
        'hpp',
        'automargin',
        'minsales',
        'pricelist',
        'currency',
        'lastpurchase',
        'is_active',
        'WSPrice',
        'brand',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'hpp' => 'decimal:2',
        'automargin' => 'decimal:2',
        'minsales' => 'decimal:2',
        'pricelist' => 'decimal:2',
        'WSPrice' => 'decimal:2',
        'lastpurchase' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
