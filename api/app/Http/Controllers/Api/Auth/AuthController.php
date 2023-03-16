<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = validator(
            $request->all(),
            [
                'email'     => 'required|email',
                'password'  => 'required|string'
            ],
            [
                'email.required'      => 'Please Give User Email',
                'password.required'      => 'Please Give User Password',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'message'   => $validator->getMessageBag()->first(),
                'errors'    => $validator->getMessageBag()
            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
                'status'        => 200,
                'message'       => 'Logged in successfully',
                'user'          => $user,
                'access_token'  => $accessToken
            ]);
        } else {
            return response()->json([
                'status'    => 401,
                'message'   => 'Sorry Invalid Email and Password',
                'errors'    => null
            ]);
        }
    }
}
