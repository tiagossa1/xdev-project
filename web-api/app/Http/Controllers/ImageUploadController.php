<?php

namespace App\Http\Controllers;

use App\User;
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
            $user = User::find($request->user_id);

            if (!is_null($user)) {
                // $file_name = time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                // $file_name = time() . '.' . $request->profile_picture->getClientOriginalExtension();
                // $request->profile_picture->move(public_path('images'), $file_name);
                // $path = "public/images/" . $file_name;

                $result = $request->file('profile_picture')->store('images');
                $base64 = base64_encode($result);

                $user->profile_picture = $base64;
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
            return response()->json(['error' => $exception->getMessage()], 500);
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
