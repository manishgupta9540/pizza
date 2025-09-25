<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'total_amount', 'customer_name', 'customer_email', 'status'];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


}
