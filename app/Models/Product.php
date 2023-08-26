<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'status',
        'image',
    ];
    protected $casts = [
        'status' => 'boolean'
    ];

    public function cartProduct()
    {
        return $this->hasOne(Cart::class, 'product_id', 'id')->where('user_id', auth()->user()->id);
    }
}
