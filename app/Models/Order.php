<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'product_id',
        'user_id',
        'status',
        'quantity',
        'price',
        'delivery_data',
    ];

    protected $casts = ['delivery_data' => 'json'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
