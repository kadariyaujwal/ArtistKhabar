<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function profile(){
        $user = auth('api')->user();
        return $user;
    }

    public function updateProfile(Request $request){
        $user = auth('api')->user();
        $request->validate([
            'name'=>'required|string|max:191',
            'email'=>'required|email|max:191|unique:users,email,'.$user->id,
            'password'=>'sometimes|string',
        ]);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password?bcrypt($request->password):$user->password
        ]);
        return response()->json([
            'message'=>'User updated successfully',
            'error'=>false
        ]);
    }
}
