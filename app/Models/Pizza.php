<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function prices()
    {
        return $this->hasMany(PizzaSize::class);
    }

    public function getPriceBySize($size)
    {
        return $this->prices()->where('size', $size)->first()->price ?? 0;
    }
    
}
