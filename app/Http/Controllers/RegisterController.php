<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){

    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|numeric|digits:11|regex:/^09/',
        ]);
        $user=User::query()->create([
            'name' => $request->name,
            'phone' => $request->phone_number,
        ]);
        auth()->login($user);
        return new RegisterResource($user);

    }
}
