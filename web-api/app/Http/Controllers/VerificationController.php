<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request)
    {
       if(!$request->hasValidSignature()){
            return response()->json(['message' => 'Unauthorized'],401);
        }

        $user = User::findOrFail($user_id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'],400);
        }
        else{
            $user->markEmailAsVerified();
            event(new Verified($request->user()));
        }
        return response()->json(['message' => 'Successfully verified'],200);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'],200);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Email Sent'],200);
    }
}
