<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $table = 'users';

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'birth_date' => 'required',
            'password' => 'required',
            'district_id' => 'required',
            'user_type_id' => 'required',
            'school_class_id' => 'required'
        ]);

        $user = \App\User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'birth_date' => $fields['birth_date'],
            'password' => bcrypt($fields['password']),
            'district_id' => $fields['district_id'],
            'user_type_id' => $fields['user_type_id'],
            'school_class_id' => $fields['school_class_id']
        ]);

        $token = $user->createToken('xdevToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Logged Out.'
        ];
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
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
