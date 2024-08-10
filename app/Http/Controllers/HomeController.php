<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Home Page
    public function index()
    {
        return new ProductCollection(Product::query()->paginate(12));
    }

    // Show Product
    public function showProduct($id){
        $product=Product::query()->where('id',$id)->first();
        if ($product) {

            return response()->json([
                'productName' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $product->category->name,
                'image' => $product->image,
                'is_available' => $product->is_available,

            ]);
        }else{
            return response()->json(['message' => 'Product not found'],404);
        }

    }

}
