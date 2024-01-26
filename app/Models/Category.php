<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['category', 'description', 'state_id'];

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
