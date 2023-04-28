<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'surname',
            'address',
            'external_address',
            'phone',
            'external_phone',
            'balance',
            'coupon',
            'status',
            'note',
        ];
    protected $casts =
        [
            'status' => 'boolean'
        ];

}
