<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\GetProfilePictureRequest;

class ImageUploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            // $user->refresh();

            if (!$request->hasFile('profile_picture')) {
                return response()->json(['Profile picture is mandatory.'], 400);
            }

            if (!is_null($user)) {
                //$file_name = time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                $file_name = time() . '.' . $request->profile_picture->getClientOriginalExtension();
                $request->profile_picture->move(public_path('images'), $file_name);
                $path = "public/images/" . $file_name;

                $user->profile_picture = $path;
                $user->update();

                return response()->json([
                    'data' => $user,
                    'message' => 'Success',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User does not exist.',
                ], 404);
            }
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProfilePicture(GetProfilePictureRequest $request)
    {
        $path = dirname(public_path(), 1) . '/' . $request->profile_picture;
        return response()->json(['data' => base64_encode(file_get_contents($path)), 'message' => 'Success']);

        // return Response::download($path);
    }
}
