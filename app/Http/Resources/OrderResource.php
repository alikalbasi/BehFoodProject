<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->user->name,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
//                    'address_title' => $this->address->title,
            'address' => $this->address->address,
            'created_at' => $this->created_at,
            'items' => $this->items,
        ];
    }
}
