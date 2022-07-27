<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            
           $success['token'] =  $user->createToken('MyApp',['user'])->accessToken; 
           
   
           return response()->json($success, 200);
        } 
        else{ 
           return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        } 
    }

    public function logout(Request $request)
    {

        auth()->guard('user')->logout();

        $request->user()->token()->revoke();


        return "success";
    }
}
