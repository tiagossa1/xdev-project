<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $table = 'users';

    public function register(RegisterAuthRequest $request)
    {
        try {
            $request->validate($request->rules());

            $userCount = User::where('email', '=', $request['email'])->count();

            if ($userCount == 0) {
                if ($request["user_type_id"] == 1) {
                    $user = \App\User::create([
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'birth_date' => $request['birth_date'],
                        'password' => bcrypt($request['password']),
                        'district_id' => $request['district_id'],
                        'user_type_id' => $request['user_type_id'],
                        'school_class_id' => $request['school_class_id'],
                    ]);

                    $token = $user->createToken('xdevToken')->plainTextToken;

                    $response = [
                        'user' => $user,
                        'token' => $token,
                    ];

                    return response($response, 201);
                } else {
                    return response(['message' => 'A user cannot be created with higher privileges.'], 400);
                }
            } else {
                return response(['message' => 'User already exists.'], 400);
            }
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Logged Out.',
        ];
    }

    public function login(LoginAuthRequest $request)
    {
        $request->validate($request->rules());

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials',
            ], 401);
        }

        $token = $user->createToken('xdevToken')->plainTextToken;

        // if(!is_null($user->profile_picture)) {
        //     $user->setProfilePicture($user->profile_picture);
        // }
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function changePassword(Request $request) {
        $input = $request->all();
        $userId = Auth::user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response([
                'message' => $validator->errors(),
            ], 400);
        } else {
            try {
                if (!Hash::check(request('old_password'), Auth::user()->password)) {
                    return response([
                        'message' => "Old password is wrong.",
                    ], 400); 
                } else if ((Hash::check($request['new_password'], Auth::user()->password)) == true) {
                    return response([
                        'message' => "Please enter a password which is not similar then current password.",
                    ], 400);
                } else {
                    User::where('id', $userId)->update(['password' => Hash::make($input['new_password'])]);
                    return response([
                        'message' => "Password updated successfully.",
                    ], 200);
                }
            } catch (Exception $ex) {
                return response([
                    'message' => $ex->getMessage(),
                ], 500);
            }
        }
    }
}
