<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    
    public function pizzaprices()
    {
        return $this->hasMany(ToppingPrice::class);
    }

    public function getPriceBySize($pizzaSize)
    {
        return $this->pizzaprices()->where('pizza_size', $pizzaSize)->first()->price ?? 0;
    }


}
