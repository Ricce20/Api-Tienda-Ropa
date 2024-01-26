<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['companyName', 'contact','address','city','c_p','email','phone', 'state_id'];

    protected $attributes = [
        'state_id' => '1', // Valor por defecto para id_state
    ];
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
