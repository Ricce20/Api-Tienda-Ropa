<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEntry extends Model
{
    use HasFactory;

    protected $table = 'product_entries';

    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity',
        'unit_price',
        'total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
}
