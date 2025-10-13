<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class MSupplier extends Model
{
    // use HasFactory, SoftDeletes;

    protected $table = 'm_supplier';
    protected $primaryKey = 'id_supplier';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'zipcode',
        'telephone',
        'fax',
        'email',
        'tax_name',
        'tax_address',
        'tax_city',
        'tax_country',
        'tax_zipcode',
        'tax_id',
        'is_active',
        'pic_1',
        'ext_1',
        'pic_2',
        'ext_2',
        'pic_3',
        'ext_3'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
