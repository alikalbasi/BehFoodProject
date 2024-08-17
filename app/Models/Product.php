<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id'
    ];


    public function orders(){
        return $this->belongsToMany(Order::class, 'order_items')->withPivot([
            'price', 'quantity'
        ]);
    }

    public function carts(){
        return $this->belongsToMany(Cart::class, 'cart_items');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
