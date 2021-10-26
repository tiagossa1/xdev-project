<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Notifications\NewPost;
use Illuminate\Support\Facades\DB;
use App\Notifications\UpdateReport;
use App\Http\Requests\CreatePostRequest;
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
                $newPostNotification = new NewPost(Post::find($post->id));
                Notification::send($users, $newPostNotification);

                event(new PostCreated(Post::find($post->id)));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            return response()->json([
                'data' => Post::find($id),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $post = Post::find($id);

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

            // $moderatorIds = [2, 4];

            // if($post->suspended && !in_array(Auth::user()->user_type->id, $moderatorIds)) {
            //     $mods = User::whereIn('user_type_id', $moderatorIds)->get();

            //     if(!is_null($mods))
            //         Notification::send($mods, new UpdateReport($post));
            // }

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);

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
