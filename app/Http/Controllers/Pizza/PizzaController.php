<?php

namespace App\Http\Controllers\Pizza;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Topping;

class PizzaController extends Controller
{
    public function index()
    {
        $pizzas     = Pizza::with('pizzaprices')->get();
        $toppings   = Topping::with('pizzaprices')->get();
        return view('pizza.index', compact('pizzas', 'toppings'));
    }


    public function amountCalculate(Request $request)
    {
        $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'size' => 'required|in:small,medium,large',
            'toppings' => 'array'
        ]);

        try {
            $pizza = Pizza::findOrFail($request->pizza_id);
            $basePrice = $pizza->getPriceBySize($request->size);
            $toppingsPrice = 0;

            if ($request->toppings) {
                foreach ($request->toppings as $toppingId) {
                    $topping = Topping::find($toppingId);
                    $toppingsPrice += $topping->getPriceBySize($request->size);
                }
            }

            $totalPrice = $basePrice + $toppingsPrice;
    
            return response()->json([
                'base_price' => $basePrice,
                'toppings_price' => $toppingsPrice,
                'total_price' => $totalPrice
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'error'=>$th->getMessage(),
            ]);
        }
    }

}
