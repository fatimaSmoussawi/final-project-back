<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RejesterRequest;

class AuthController extends Controller
{
    public function register(RejesterRequest $request)
    {
        $user = User::create([
             'firstName' => $request->firstName,
             'lastName' => $request->lastName,
             'userName' => $request->userName,
             'email'    => $request->email,
             'password' => $request->password,
             'avatar' => $request->avatar,
             'cover' => $request->cover,
             'channelDescription' => $request->channelDescription,
            //  'isAdmin' => $request->isAdmin,

         ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
