<?php

namespace App\Http\Controllers\auth;

//use App\Http\Controllers\Controller;
//use http\Client\Curl\User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function register( Request $request) {
        $validated = $request->validate([
           'name' => 'required|max:55',
           'email' => 'email|required|unique:users',
           'password' => 'required|confirmed'
        ]);

        $user = User::create($validated);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }
}
