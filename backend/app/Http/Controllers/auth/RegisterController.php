<?php

namespace App\Http\Controllers\auth;

//use App\Http\Controllers\Controller;
//use http\Client\Curl\User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register( Request $request) {
        $validated = $request->validate([
           'name' => 'required|max:55',
           'email' => 'email|required|unique:users',
           'password' => 'required'
        ]);

        $request->merge(['password' => bcrypt($request->password)]);

        $user = User::create($request->all());

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }
}
