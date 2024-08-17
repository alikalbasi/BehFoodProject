<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{

    // Register New User
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|numeric|digits:11|regex:/^09/',
        ]);
        $user=User::query()->create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);
        $token=$user->createToken('authToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);

    }

    // Login User
    public function login(Request $request){
        $request->validate([
            'phone_number' => 'required|numeric|digits:11|regex:/^09/',
        ]);
        $user = User::where('phone_number', $request->phone_number)->first();
        $otp = random_int(1000, 9999);
        DB::table('otp')->insert([
            'user_id' => $user->id ?? null,
            'phone_number' => $request->phone_number,
            'otp' => $otp,
            'expired_at' => now()->addMinutes(5)
        ]);
        return response()->json(['message' => 'کد تایید به شماره شما ارسال شد.']);
    }

    // Verify User With PhoneNumber
    public function verify(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric|digits:11|regex:/^09/',
            'otp' => 'required|numeric|digits:4'
        ]);

        $otpRecord = DB::table('otp')
            ->where('phone_number', $request->phone_number)
            ->where('expired_at', '>', now())
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return response()->json(['error' => 'کد تایید نامعتبر یا منقضی شده است.'], 401);
        }

        if (!$otpRecord->user_id) {
            $user = User::create([
                'name' => 'تست',
                'phone_number' => $request->phone_number,
            ]);
        } else {
            $user = User::find($otpRecord->user_id);
        }
        DB::table('otp')->where('id', $otpRecord->id)->delete();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token]);

    }

}
