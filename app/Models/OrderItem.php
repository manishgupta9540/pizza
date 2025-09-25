<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;


    protected $fillable = ['order_id', 'pizza_id', 'size', 'quantity', 'unit_price', 'total_price'];

    
    public function pizza()
    {
        return $this->belongsTo(Pizza::class);
    }


    public function toppings()
    {
        return $this->hasMany(OrderItemTopping::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
