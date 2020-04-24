<?php

namespace App\Http\Controllers\auth;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $login = $request->validate([
           'email' => 'required|email',
           'password' => 'required|string'
        ]);

        if( !Auth::attempt($login)){
            return response(['message' => 'Invalid login credentials'], 401);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response(['user' => Auth::user(), 'access_token' => $accessToken]);
    }
}
