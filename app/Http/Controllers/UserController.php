<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

//class UserController extends Controller
class UserController extends Controller
{
//    public function index(){
////        $users=User::query()->where('id',4)->first();
////        $users=User::query()->paginate(5);
////        $users=User::query()->limit(5)->get();
//        $users=User::query()->get();
//        return response()->json($users);
//
//    }
      public function index(){
          $users = User::all();
//          $users = User::query()->limit(1)->first();
          return new UserResource($users);
      }
}
