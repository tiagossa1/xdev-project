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
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*    public function store(Request $request)
        {
            try {
                $user = User::create($request->all());

                $user->posts()->async($request->input('posts'));
                $user->feedbacks()->async($request->input('feedbacks'));
                $user->reports()->async($request->input('reports'));
                $user->tags()->async($request->input('tags'));

                return response()->json([
                    'data' => $user,
                    'message' => 'Success'
                ], 201);

            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }
        }*/

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

            if(!is_null($user)) {
                $user->setProfilePicture($user->profile_picture);
            }

            return response()->json($user, 200);
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
            $user->update($request->all());

            $user->tags()->sync($request->input('tags'));
            $user->favorite_posts()->sync($request->input('favorite_posts'));
            $user->liked_posts()->sync($request->input('liked_posts'));

            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 201);

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
            return response()->json(['message' => 'Deleted'], 205);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
