<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function pizzaprices()
    {
        return $this->hasMany(PizzaSize::class);
    }

    public function getPriceBySize($size)
    {
        return $this->pizzaprices()->where('size', $size)->first()->price ?? 0;
    }
    
}
