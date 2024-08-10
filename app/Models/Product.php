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


    public function orderItem(){
        return $this->belongsToMany(OrderItem::class);
    }

    public function cartItem(){
        return $this->belongsToMany(CartItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
