<?php

namespace App\Http\Controllers;

use App\Events\UserEmailVerified;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::findOrFail($user_id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'O email já foi verificado.'], 400);
        } else {
            $user->markEmailAsVerified();
            event(new UserEmailVerified($user));
        }

        return response()->json(['message' => 'User verificado com sucesso!'], 200);
    }

    public function isUserVerified(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        return response()->json(['isVerified' => $user->hasVerifiedEmail()], 200);
    }

    public function resend(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if (!is_null($user)) {
            if ($user->hasVerifiedEmail()) {
                return response()->json(['message' => 'O email já foi verificado.'], 400);
            }

            $user->sendEmailVerificationNotification();
            return response()->json(['message' => 'Email reenviado com sucesso!'], 200);
        }
    }
}
