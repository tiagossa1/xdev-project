<?php

namespace App\Http\Controllers;

use App\Post;
use Exception;
use Illuminate\Http\Request;

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
                'data' => Post::with('user','tags', 'user.school_class', 'user.school_class.school', 'user.user_type', 'post_photos', 'post_type', 'comments', 'likes')->latest()->get(),
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
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

            $post->tags()->sync($request->input('tags'));

            return response()->json([
                'data' => $post,
                'message' => 'Success'
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
                'data' => $post->load('user', 'tags' , 'user.school_class', 'user.school_class.school', 'user.user_type', 'post_photos', 'post_type', 'comments', 'likes'),
                'message' => 'Success'
            ], 201);

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

            if(!is_null($request->input('tags')))
                $post->tags()->sync($request->input('tags'));

            if(!is_null($request->input('likes')))
                $post->likes()->sync($request->input('likes'));

            return response()->json([
                'data' => $post,
                'message' => 'Success'
            ], 201);

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
            $post->delete();
            
            return response()->json(['message' => 'Deleted'], 205);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
