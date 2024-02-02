<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'orderDate','total','state_id'];

    protected $attributes = [
        'state_id' => '3', // Valor por defecto para id_state
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function detailorders()
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
