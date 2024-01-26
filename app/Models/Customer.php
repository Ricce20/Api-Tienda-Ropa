<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    public function orders()
    {
        return $this->hasMany(Orders::class); 
    }

    // public function carts()
    // {
    //     return $this->hasMany(Cart::class);
    // }

    // public function cart()
    // {
    //     return $this->hasMany(Cart::class);
    // }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
