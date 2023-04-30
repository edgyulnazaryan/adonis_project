<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Webmozart\Assert\Tests\StaticAnalysis\boolean;

class Resource extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'name',
            'quantity',
            'price',
            'currency',
            'unit_measurement',
            'image',
            'status',
            'supplier_id',
        ];
    protected $casts =
        [
            'status' => 'boolean'
        ];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
}
