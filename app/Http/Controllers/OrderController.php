<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemCollection;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderItemCollection;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Show Orders
    public function Show()
    {
        $order=new OrderCollection(Order::query()->where('user_id', auth()->user()->id)->paginate(6));
        if (count($order)===0){
            return response()->json(['message' => 'شما سفارشی ثبت نکرده اید']);
        }
        return response()->json([
           'orders'=>$order,
        ]);
    }

    // Create New Order
    public function Add(Request $request)
    {
        $request->validate([
            'payment_method'=>'required',
            'address_id'=>'required|exists:addresses,id'
        ]);
        $cart= Cart::query()->where('user_id', auth()->user()->id)->first();
        if ($cart!=null) {
            $cartItem = $cart->items()->get();
            $cartItems = $cart->items();
            $order = Order::query()->create([
                'user_id' => $cart->user_id,
                'total_price' => $cart->total_price,
                'payment_method' => $request->payment_method,
                'address_id' => $request->address_id,
            ]);
            $order->save();
            $count = count($cartItem);
            for ($i = 0; $i < $count; $i++) {
                $orderItem = OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem[$i]->product_id,
                    'quantity' => $cartItem[$i]->quantity,
                    'price' => $cartItem[$i]->price,
                    'total_price' => $cartItem[$i]->total_price
                ]);
            }
            $orderItem->save();
            $cartItems->delete();
            $cart->delete();
            return response()->json([
                'message' => 'سفارش شما ثبت شد',
                'user_name'=>$order->user->name,
                'total_price'=>$order->total_price,
                'payment_method'=>$order->payment_method,
                'address_title'=>$order->address->title,
                'address'=>$order->address->address,
                'created_at'=>$order->created_at,
                'order_item'=>[
                    'products'=>$order->item->map(function ($item) {
                        return[
                            'product'=>$item->product->name,
                            'product_description'=>$item->product->description,
                            'product_price'=>$item->product->price,
                            'quantity'=>$item->quantity,
                            'total_price'=>$item->total_price,
                        ];
                    })
                ]
            ]);
        }else{
            return response()->json([
                'message' => 'سبد خرید شما خالی است',
            ],404);
        }


    }
}
