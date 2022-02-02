<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
//        register user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
//        create unique token for user
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
//        check email
        $user = User::where('email', $request->email)->first();

//        check password
        if (!$user || !Hash::check($request->password , $user->password)) {
            return response()->json([
                'message' => 'email or password not match!'
            ], 401);
        }
//        create unique token for user
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
//        delete user by token
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged out',
        ], 201);
    }

    public function changePassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
//        get user
        $user = $request->user();
//        check password and update
        if (Hash::check($request->old_password , $user->password)){
            $user->update([
                'password' =>bcrypt( $request->password)
            ]);

            return response()->json([
                'message' => 'Password successfully updated'
            ],200);
        }
       return response()->json([
            "message" => " Old password doesn't match ",
        ],400);
    }

    public function admin()
    {
//        get and show admin users
        return User::where('is_admin' , 1)->get();
    }

    public function users()
    {
//        get and show users
        return User::where('is_admin' , 0)->get();
    }
}
