<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'surname',
            'email',
            'password',
            'position_id',
            'address',
            'date_of_birth',
            'phone',
            'external_phone',
            'balance',
            'salary',
            'coupon',
            'status',
            'note',
            'image',
        ];
    protected $casts =
        [
            'status' => 'boolean'
        ];

}
