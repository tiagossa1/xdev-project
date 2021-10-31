<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginAuthRequest;
use \Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterAuthRequest;

class AuthController extends Controller
{
    protected $table = 'users';

    public function getUserByToken()
    {
        return Auth::user();
    }

    public function register(RegisterAuthRequest $request)
    {
        try {
            $request->validate($request->rules());

            $userCount = User::where('email', '=', $request['email'])->count();

            if ($userCount == 0) {
                if ($request["user_type_id"] == 1) {
                    $user = new User();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->birth_date = $request->birth_date;
                    $user->password = bcrypt($request->password);
                    $user->district_id = $request->district_id;
                    $user->user_type_id = $request->user_type_id;
                    $user->school_class_id = $request->school_class_id;
                    $user->profile_picture = $request->profile_picture;
                    $user->save();

                    $user->sendEmailVerificationNotification();

                    return response()->json(['message' => 'Utilizador criado, foi enviado um email de confirmação.'], 201);
                } else {
                    return response(['message' => 'A user cannot be created with higher privileges.'], 400);
                }
            } else {
                return response(['message' => 'User already exists.'], 400);
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
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

    public function isModerator()
    {
        $moderatorIds = [2, 3, 4];

        if (in_array(Auth::user()->user_type->id, $moderatorIds)) {
            return response()->json(['isModerator' => true], 200);
        } else {
            return response()->json(['isModerator' => false], 200);
        }
    }

    public function isSheriff()
    {
        $xSheriff = UserType::where('name', 'LIKE', '%sheriff%')->first();

        if (Auth::user()->user_type->id == $xSheriff->id) {
            return response()->json(['isxSheriff' => true], 200);
        } else {
            return response()->json(['isxSheriff' => false], 200);
        }

        // return response()->json([], 401);
    }

    public function login(LoginAuthRequest $request)
    {
        $request->validate($request->rules());

        $user = User::where('email', $request['email'])->first();

        if(is_null($user)) {
            return response()->json(['message' => 'O utilizador não existe.'], 404);
        }

        // JSON_UNESCAPED_UNICODE is used due to UTF-8 characters in Portuguese language.

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'O utilizador não verificou o email.',
                'type' => 'UserDidNotVerifiedEmail',
            ], 401, [], JSON_UNESCAPED_UNICODE);
        } else if ($user->suspended == 1) {
            return response()->json([
                'message' => "O utilizador está suspenso. Por favor, contacte um moderador."
            ], 401);
        }

        // When login in, it's not needed to load the following entities:
        // unset($user->tags);
        unset($user->favorite_posts);
        unset($user->liked_posts);

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'Credenciais erradas. Por favor, verifique-as.',
            ], 401);
        }

        $token = $user->createToken('xdevToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function changePassword(Request $request)
    {
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
            } catch (Exception $exception) {
                return response([
                    'message' => $exception->getMessage(),
                ], 500);
            }
        }
    }
}
