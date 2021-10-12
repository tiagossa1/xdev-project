<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user = User::with('district', 'school_class', 'school_class.school', 'user_type','posts', 'feedbacks', 'reports', 'tags', 'favorite_posts', 'liked_posts', 'comments')->get();

            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        try {
            $user = $user->load('district', 'school_class','school_class.school', 'user_type','posts', 'posts.post_type', 'posts.tags', 'posts.users_saved', 'posts.post_photos', 'feedbacks', 'reports', 'tags', 'favorite_posts', 'liked_posts', 'comments');

            // if(!is_null($user) && !is_null($user->profile_picture)) {
            //     $user->setProfilePicture($user->profile_picture);
            // }

            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return  response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        try {
            $user = User::find($user->id);
            $user->name = $request->name;

            $user->github_url = $request->github_url;
            $user->linkedin_url = $request->linkedin_url;
            $user->facebook_url = $request->facebook_url;
            $user->instagram_url = $request->instagram_url;

            $user->password = bcrypt($request->password);
            $user->save();

            $user->tags()->sync($request->input('tags'));
            $user->favorite_posts()->sync($request->input('favorite_posts'));
            $user->liked_posts()->sync($request->input('liked_posts'));

            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Deleted'], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
