<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(){
        request()->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email',request()->get('email'))->first();

        if(!$user){
            throw ValidationException::withMessages([
                'email'=>'Incorrect details'
            ]);
        }
        if(!Hash::check(request('password'),$user->password)){
             throw ValidationException::withMessages([
                'email'=>'Incorrect details'
            ]);
        }
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token'=>$token
        ]);

    }
    public function logout(){
        request()->user()->tokens()->delete();

        return response()->json([
            'message'=>'Logged Out Successfully'
        ]);

    }
}
