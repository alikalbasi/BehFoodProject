<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Order' => $this->collection->map(function ($order) {
                return [
                    'user_name' => $order->user->name,
                    'total_price' => $order->total_price,
                    'status' => $order->status,
                    'payment_method' => $order->payment_method,
                    'address_title' => $order->address->title,
                    'address' => $order->address->address,
                    'created_at' => $order->created_at,
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

                ];
            }),
        ];
    }
}
