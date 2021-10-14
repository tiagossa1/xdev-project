<?php

namespace App\Http\Controllers;

use App\Notifications\NewPost;
use App\Post;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
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
                'data' => Post::all(),
                'message' => 'Success',
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function filter(Request $request) {
        try {
            // $query = Post::with('user', 'tags', 'user.school_class', 'user.school_class.school', 'user.user_type', 'post_photos', 'post_type', 'comments', 'comments.user', 'comments.user.user_type', 'likes', 'users_saved');

            $query = Post::query();

            if($request->user_id) {
                $query->where('user_id', $request->user_id);
            }
    
            $posts = $query->get();
    
            return response()->json([
                'message' => 'Success',
                'data' => $posts
            ], 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $post = Post::create($request->all());

            $post->tags()->attach($request->input('tags'));

            $users = User::where('id', '=', function ($query) use ($post) {
                $query->select('user_id')->from('tag_user')->whereIn('tag_id', $post->tags()->get());
            })->get();

            if (!is_null($users)) {
                Notification::send($users, new NewPost($post));
            }

            return response()->json([
                'data' => $post,
                'message' => 'Success',
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        try {
            return response()->json([
                'data' => $post->load('user', 'tags', 'user.school_class', 'user.school_class.school', 'user.user_type', 'post_photos', 'post_type', 'comments', 'comments.user', 'comments.user.user_type', 'likes', 'users_saved'),
                'message' => 'Success',
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        try {
            $post->update($request->all());

            if (!is_null($request->input('tags'))) {
                $post->tags()->sync($request->input('tags'));
            }

            if (!is_null($request->input('likes'))) {
                $post->likes()->sync($request->input('likes'));
            }

            if (!is_null($request->input('users_saved'))) {
                $post->users_saved()->sync($request->input('users_saved'));
            }

            return response()->json([
                'data' => $post,
                'message' => 'Success',
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        try {
            $post->post_photos()->delete();
            $post->comments()->delete();
            $post->likes()->delete();
            $post->users_saved()->delete();
            $post->delete();

            return response()->json(['message' => 'Deleted'], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
