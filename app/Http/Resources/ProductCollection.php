<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Products' => $this->collection->map(function ($product) {
                return [
                    'name' => $product->name,
                    'description' => $product->description,
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                    'category_id' => $product->category->name,
                    'image' => $product->image,
                    'is_available' => $product->is_available,
                ];
            }),
        ];
    }
}
