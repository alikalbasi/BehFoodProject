<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add To Cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',

        ]);
        $product = Product::findOrFail($request->product_id);
        if ($request->quantity > $product->quantity) {
            return['errors' => 'تعداد وارد شده بیشتر از موجودی کالا است'];
        }
        if (!Cart::query()->where('user_id', auth()->user()->id)->exists()) {
            $createCart = new Cart(
                [
                    'user_id' => auth()->id(),
                    'total_price' => 0
                ]
            );
            $createCart->save();

            $cartItem = $createCart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                $cartItem = new CartItem([
                    'cart_id' => $createCart->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $request->quantity,
                    'total_price' => $product->price * $request->quantity

                ]);
                $createCart->items()->save($cartItem);
                $createCart->total_price = CartItem::query()->where('cart_id', $createCart->id)->sum('total_price');
                $createCart->update();

            }
            return response()->json(['message' => 'محصول با موفقیت به سبد خرید اضافه شد'],202);
        }else{
            $cart= Cart::query()->where('user_id', auth()->user()->id)->first();
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                $cartItem = new CartItem([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $request->quantity,
                    'total_price' => $product->price * $request->quantity

                ]);
                $cart->items()->save($cartItem);
                $cart->total_price = CartItem::query()->where('cart_id', $cart->id)->sum('total_price');
                $cart->update();

            }
            return response()->json(['message' => 'محصول با موفقیت به سبد خرید اضافه شد']);

        }
    }

    // Show Cart
    public function showCart(Request $request)
    {

        $cart=Cart::query()->where('user_id', auth()->user()->id)->first();
        if ($cart===null){
            return response()->json(['yourCart' => 'سبد خرید شما خالی است'],404);
        }
        return new CartItemCollection(CartItem::query()->where('cart_id', $cart->id)->paginate(6));
    }

    // Destroy Cart
    public function destroyCart(Request $request){
        $cart= Cart::query()->where('user_id', auth()->user()->id)->first();
        if ($cart===null){
            return response()->json(['yourCart' => 'سبد خرید شما خالی است'],404);
        }
        $cartItem = $cart->items();
        $cartItem->delete();
        $cart->delete();
        return response()->json(['message' => 'سبد خرید با موفقیت حذف شد']);
    }

    // Less Count Product
    public function lessItem(Request $request)
    {
        $cart= Cart::query()->where('user_id', auth()->user()->id)->first();
        if ($cart===null){
            return response()->json(['yourCart' => 'سبد خرید شما خالی است']);
        }
        $request->validate([
            'product_id' => 'required|exists:cart_items,product_id',
        ]);
        $cartItem=$cart->items()->where('product_id', $request->product_id)->first();
        $cartItem->quantity--;
        $cartItem->total_price=$cartItem->quantity * $cartItem->price;
        if ($cartItem->quantity<=0){
            $cartItem->where('product_id', $request->product_id)->delete();
            $cartItem->update();
            $cart->total_price = CartItem::query()->where('cart_id', $cart->id)->sum('total_price');
            $cart->update();
            return response()->json([
                'messages' => 'کالا حذف شد',
                'yourCart' => $cartItem,
            ]);
        }
        $cartItem->update();
        $cart->total_price = $cartItem->query()->where('cart_id', $cart->id)->sum('total_price');
        $cart->update();
        return response()->json([
            'messages' => 'تعداد کالا با موفقیت یک واحد کاهش یافت',
            'yourCartItem' => $cartItem,
            'yourCart'=>$cart
        ]);

    }

    // More Count Product
    public function moreItem(Request $request)
    {
        $cart= Cart::query()->where('user_id', auth()->user()->id)->first();
        if ($cart===null){
            return response()->json(['yourCart' => 'سبد خرید شما خالی است']);
        }
        $request->validate([
            'product_id' => 'required|exists:cart_items,product_id',
        ]);
        $product = Product::findOrFail($request->product_id);
        $cartItem=$cart->items()->where('product_id', $request->product_id)->first();
        if ($cartItem->quantity >= $product->quantity) {
            return['errors' => 'تعداد وارد شده بیشتر از موجودی کالا است'];
        }else {
            $cartItem->quantity++;
            $cartItem->total_price=$cartItem->quantity * $cartItem->price;
            $cartItem->update();
            $cart->total_price = $cartItem->query()->where('cart_id', $cart->id)->sum('total_price');
            $cart->update();
            return response()->json([
                'messages' => 'تعداد کالا با موفقیت یک واحد افزایش یافت',
                'yourCartItem' => $cartItem,
                'yourCart' => $cart
            ]);
        }

    }

}
