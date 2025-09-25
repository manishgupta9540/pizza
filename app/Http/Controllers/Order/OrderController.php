<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemTopping;
use App\Models\Pizza;
use App\Models\Topping;


class OrderController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string',
            'pizzas' => 'required|array|min:1',
            'pizzas.*.pizza_id' => 'required|exists:pizzas,id',
            'pizzas.*.size' => 'required|in:small,medium,large',
            'pizzas.*.toppings' => 'array'
        ]);
        try {
            //code...
            $totalAmount = 0;
            $orderItems = [];
            $pizzas =$request->pizzas ?? [];
            $toppingsPrice = 0;
            foreach ($pizzas as $pizzaData) {
                $pizza = Pizza::find($pizzaData['pizza_id']);
                $basePrice = $pizza->getPriceBySize($pizzaData['size']);
                
                if (isset($pizzaData['toppings'])) {
                    foreach ($pizzaData['toppings'] as $toppingId) {
                        $topping = Topping::find($toppingId);
                        $toppingsPrice = $topping->getPriceBySize($pizzaData['size']);
                    }
                }
                // dd($basePrice,$toppingsPrice);
                $itemTotal = $basePrice + $toppingsPrice;
                $totalAmount += $itemTotal;
                // dd($totalAmount);
                $orderItems[] = [
                    'pizza' => $pizza,
                    'size' => $pizzaData['size'],
                    'base_price' => $basePrice,
                    'toppings' => $pizzaData['toppings'] ?? [],
                    'toppings_price' => $toppingsPrice,
                    'item_total' => $itemTotal
                ];
            }
            
            // Create order
            $order = Order::create([
                'total_amount' => $totalAmount,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'delivery_address' => $request->delivery_address,
                'status' => 'pending'
            ]);
    
            // Create order items
            foreach ($orderItems as $itemData) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'pizza_id' => $itemData['pizza']->id,
                    'size' => $itemData['size'],
                    'quantity' => 1,
                    'unit_price' => $itemData['base_price'],
                    'total_price' => $itemData['item_total']
                ]);
    
                // Add toppings
                foreach ($itemData['toppings'] as $toppingId) {
                    $topping = Topping::find($toppingId);
                    OrderItemTopping::create([
                        'order_item_id' => $orderItem->id,
                        'topping_id' => $toppingId,
                        'price' => $topping->getPriceBySize($itemData['size'])
                    ]);
                }
            }
    
            return response()->json([
                'success' => true,
                'total_amount' => $totalAmount,
                'message' => 'Order placed successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
       
    }
}
