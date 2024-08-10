<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    // Show Addresses
    public function Show()
    {
        $address=Addresses::query()->where('user_id', auth()->user()->id)->paginate(6);
        if (count($address)===0){
            return response()->json(['yourAddresses' => 'شما آدرسی ذخیره نکرده اید'],404);

        }
        return response()->json(['yourAddresses' => $address]);

    }

    // Add Address
    public function Add(Request $request)
    {
        $request->validate([
            'title'=>'required|max:30|min:3|unique:addresses',
            'address'=>'required|max:300|min:5|unique:addresses',
        ]);
        Addresses::query()->create([
            'user_id'=>auth()->user()->id,
            'title'=>$request->title,
            'address'=>$request->address,
        ]);
        return response()->json(['message' => 'آدرس با موفقیت ذخیره شد']);
    }

    // Remove Address
    public function Remove($id)
    {
        Addresses::query()->findOrFail($id)->delete();
        return response()->json(['message' => 'آدرس با موفقیت حذف شد']);
    }
}
