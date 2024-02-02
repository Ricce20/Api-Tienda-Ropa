<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function products()
    {
        return $this->hasMany(Prodcut::class);
    }
public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
public function users()
    {
        return $this->hasMany(User::class);
    }
}
