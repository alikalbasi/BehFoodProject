<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'CartItems' => $this->collection->map(function ($cartItem) {
                return [
                    'product' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total_price' => $cartItem->total_price,
                ];
            }),
        ];
    }
}
