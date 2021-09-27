<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $table = 'users';

    public function register(RegisterAuthRequest $request)
    {
        try {
            $request->validate($request->rules());

            $user = \App\User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'birth_date' => $request['birth_date'],
                'password' => bcrypt($request['password']),
                'district_id' => $request['district_id'],
                'user_type_id' => $request['user_type_id'],
                'school_class_id' => $request['school_class_id']
            ]);

            $token = $user->createToken('xdevToken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Logged Out.'
        ];
    }

    public function login(LoginAuthRequest $request)
    {
        $request->validate($request->rules());

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }

        $token = $user->createToken('xdevToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}