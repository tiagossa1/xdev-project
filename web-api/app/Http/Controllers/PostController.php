<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\NewPost;
use App\Post;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Post::query();

            if ($request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            $posts = $query->latest()->get();

            return response()->json([
                'message' => 'Success',
                'data' => $posts,
            ], 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function getPostsByTags(Request $request)
    {
        try {
            // estás aí, André?
            $rules = array(
                'tags' => 'required'
            );

            $messages = array(
                'tags.required' => 'Tag is required.'
            );

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            $result = DB::table('post_tag')->whereIn('tag_id', $request->tags)->select('post_id')->get();
            $postIds = collect($result)->pluck('post_id')->toArray();

            $posts = Post::whereIn('id', $postIds)->latest()->get();

            return response()->json([
                'message' => 'Success',
                'data' => $posts,
            ], 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\CreatePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePostRequest $request)
    {
        try {
            $request->validate($request->rules());

            $post = Post::create($request->all());
            $post->tags()->attach($request->input('tags'));

            $user_id = $request->user_id;
            
            $users = User::whereIn('id', function ($query) use ($post, $user_id) {
                $query->select('user_id')->from('tag_user')->whereIn('tag_id', $post->tags()->pluck('tag_id')->toArray())->where('user_id', '<>', $user_id);
            })->get();

            if (!is_null($users) || $users->length > 0) {
                Notification::send($users, new NewPost(Post::find($post->id)));
            }

            return response()->json([
                'data' => Post::find($post->id),
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
                'data' => $post,
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
            /*$post = Post::find($post->id);

            if (!is_null($post)) {
                $post->title = $request->title;
                $post->description = $request->description;
                $post->suspended = $request->suspended;
                $post->user_id = $request->user_id;
                $post->post_type_id = $request->post_type_id;

                $post->save();
            }*/

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
                'data' => $post->fresh(),
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
