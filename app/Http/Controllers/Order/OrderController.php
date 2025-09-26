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
   
    public function pizzaOrder(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'customer_name'       => 'required|string|max:255',
            'customer_email'      => 'required|email',
            'pizzas'              => 'required|array|min:1',
            'pizzas.*.pizza_id'   => 'required|exists:pizzas,id',
            'pizzas.*.size'       => 'required|in:small,medium,large',
            'pizzas.*.toppings'   => 'array'
        ]);

        try {

            $totalAmount = 0;
            $orderItems  = [];
            $pizzaAdd = $request->pizzas;

            foreach ($pizzaAdd as $pizzaData) {
                $pizza     = Pizza::findOrFail($pizzaData['pizza_id']);
                // dd($pizza);
                $basePrice = $pizza->getPriceBySize($pizzaData['size']);

                $toppingsPrice = 0;
                $selectedToppings = $pizzaData['toppings'] ?? [];

                if (!empty($selectedToppings)) {
                    foreach ($selectedToppings as $toppingId) {
                        $topping = Topping::findOrFail($toppingId);
                        $toppingsPrice = $topping->getPriceBySize($pizzaData['size']); 
                    }
                }

                // dd($toppingsPrice,$basePrice)

                $itemTotal   = $basePrice + $toppingsPrice;
                $totalAmount += $itemTotal;

                // dd($totalAmount)

                $orderItems[] = [
                    'pizza'          => $pizza,
                    'size'           => $pizzaData['size'],
                    'base_price'     => $basePrice,
                    'toppings'       => $selectedToppings,
                    'toppings_price' => $toppingsPrice,
                    'item_total'     => $itemTotal
                ];
            }

            $order = Order::create([
                'customer_name'    => $request->customer_name,
                'customer_email'   => $request->customer_email,
                'customer_phone'   => $request->customer_phone,
                'delivery_address' => $request->delivery_address,
                'total_amount'     => $totalAmount,
                'status'           => 'pending'
            ]);

            foreach ($orderItems as $item) {
                $orderItem = OrderItem::create([
                    'order_id'    => $order->id,
                    'pizza_id'    => $item['pizza']->id,
                    'size'        => $item['size'],
                    'quantity'    => 1,
                    'unit_price'  => $item['base_price'],
                    'total_price' => $item['item_total']
                ]);

                foreach ($item['toppings'] as $toppingId) {
                    $topping = Topping::findOrFail($toppingId);
                    OrderItemTopping::create([
                        'order_item_id' => $orderItem->id,
                        'topping_id'    => $toppingId,
                        'price'         => $topping->getPriceBySize($item['size'])
                    ]);
                }
            }

            return response()->json([
                'success'      => true,
                'order_id'     => $order->id,
                'total_amount' => $totalAmount,
                'message'      => 'Order placed successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

}


