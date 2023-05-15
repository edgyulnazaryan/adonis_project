<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Employer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "employer";
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
