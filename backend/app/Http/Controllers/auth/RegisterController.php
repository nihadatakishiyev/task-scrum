<?php

namespace App\Http\Controllers\auth;

//use App\Http\Controllers\Controller;
//use http\Client\Curl\User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register( Request $request) {
//        $validated = $request->validate([
//           'name' => 'required|max:55',
//           'email' => 'email|required|unique:users',
//           'password' => 'required'
//        ]);
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['message' => implode("<br/>",$validator->messages()->all())], 422);
        }

        $request->merge(['password' => bcrypt($request->password)]);

        $user = User::create($request->all());

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }
}
