<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthControl extends Controller
{
    public function register(Request $request){
        $attrs = $request->validate([
            'name'=>'required|unique:users,name',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed'
        ]);
        $user = User::create([
            'name'=> $attrs['name'],
            'email'=>$attrs['email'],
            'password'=>bcrypt($attrs['password'])
        ]);
        return response([
            'user'=>$user,
            'token'=>$user->createToken('secret')->plainTextToken
        ],200);
    }
    public function login(Request $request){
        $attrs = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if(!Auth::attempt($attrs)){
            return response([
                'message'=>'Invalid Credintials'
            ],400);
        }
        return response([
            'user'=>auth()->user(),
            'token'=>auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response([
            'message'=>'Logout Succes'
        ],200);
    }
    public function user(){
        return response([
            'user'=>auth()->user()
        ],200);
    }
}