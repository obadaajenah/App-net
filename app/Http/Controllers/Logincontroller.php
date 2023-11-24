<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Logincontroller extends Controller
{


public function register(Request $request){
    $name=strtolower($request->name);
    $user=user::create([
        'name'=>$name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
    ]);
    $token =$user->createToken('user_token')->accessToken ;
    $user ->auth_token = $token ;
    return response()->json(['data'=>$user]);

}


public function login(Request $request){
$credential=$request->only('email','password');
$user=Auth::guard('user-api')->attempt($credential);
if(!$user)
return response()->json(['message'=>'Invalid login or password.'],401);

$user =User::where('email',$request->email)->first();
$token = $user->createToken('user_token')->accessToken ;
$user->auth_token =$token ;
return response()->json(['data'=>$user]);

}


public function logout(){
    auth()->guard('user')->user()->token()->revoke();
    return response()->json(['message'=>'logout successfully']);
}

}
