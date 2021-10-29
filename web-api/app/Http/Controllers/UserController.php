<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            return response()->json([
                'data' => User::orderBy('name')->get(),
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
    public function show($id)
    {
        try {
            $user = User::find($id);

            if(is_null($user)){
                return response()->json(['message' => "User not found!"], 404);
            }

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            $user->name =               $request->name ?? $user->name;
            $user->github_url =         $request->github_url;
            $user->linkedin_url =       $request->linkedin_url;
            $user->facebook_url =       $request->facebook_url;
            $user->instagram_url =      $request->instagram_url;
            $user->suspended =          $request->suspended ?? $user->suspended;
            $user->district_id =        $request->district_id ?? $user->district_id;
            $user->school_class_id =    $request->school_class_id ?? $user->school_class_id;
            $user->user_type_id =       $request->user_type_id ?? $user->user_type_id;

            if (!is_null($request->password)) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            $user->tags()->sync($request->input('tags'));
            $user->favorite_posts()->sync($request->input('favorite_posts'));
            $user->liked_posts()->sync($request->input('liked_posts'));

            return response()->json([
                'data' => $user->fresh(),
                'message' => 'Sucess'
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
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if(is_null($user)){
                return response()->json(['message' => "User not found!"], 404);
            }

            $user->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function getRecentActivity($id)
    {
        try {
            $comment = Comment::with('post')->where('user_id', $id)->orderByDesc('created_at')->take(3)->get();
            $post_like = DB::table('post_like')->where('user_id', $id)->orderByDesc('created_at')->take(3)->get();

            return response()->json(['comments' => $comment, 'post_likes' => $post_like]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function getFavoritePosts($id) {
        try {
            $posts = User::with('favorite_posts')->find($id)->favorite_posts;
            return response()->json(['posts' => $posts]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
