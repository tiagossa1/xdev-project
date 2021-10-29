<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Exception;
use App\ForbiddenWord;
use App\Events\PostCreated;
use Illuminate\Http\Request;
use App\Notifications\NewPost;
use App\Utilities\StringUtility;
use Illuminate\Support\Facades\DB;
use App\Notifications\UpdateReport;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
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

            if (!is_null($request->user_id)) {
                $query->where('user_id', $request->user_id);
            }

            if(!is_null($request->suspended)) {
                $query->where('suspended', $request->suspended);
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

            $forbiddenWords = ForbiddenWord::all()->pluck('name')->toArray();

            $rawTitle = explode(" ", $request->title);
            $rawDescription = explode(" ", $request->description);

            $title = StringUtility::remove_multiple_utf8($rawTitle);
            $description = StringUtility::remove_multiple_utf8($rawDescription);

            $diffDescription = array_diff($description,$forbiddenWords);
            $diffTitle = array_diff($title,$forbiddenWords);

            if(sizeof($diffTitle) == sizeof($title) && sizeof($diffDescription) == sizeof($description)) {
                /*return response()->json(['Array Description:' => sizeof($description),
                                         'Array Title:' => sizeof($title),
                                         'Array Forbidden Words:' => sizeof($forbiddenWords),
                                         'Array Description Difference:' => sizeof($diffDescription),
                                         'Array Title Difference:' => sizeof($diffTitle)]);*/

                $post = new Post();
                $post->title = $request->title;
                $post->description = $request->description;
                $post->user_id = $request->user_id;
                $post->post_type_id = $request->post_type_id;
                $post->save();

                $post->tags()->attach($request->input('tags'));

                $user_id = $request->user_id;

                $users = User::whereIn('id', function ($query) use ($post, $user_id) {
                    $query->select('user_id')->from('tag_user')->whereIn('tag_id', $post->tags()->pluck('tag_id')->toArray())->where('user_id', '<>', $user_id);
                })->get();

                if (!is_null($users) || $users->length > 0) {
                    // $post = Post::find($post->id);

                    // TODO: Mandar o post e a notificação para ser marcada como lida!
                    // FIXME: Notification não estava a funcionar. Call to undefined method App\Post::via(), 500.
                    // $notification = new NewPost($post);
                    // Notification::send($users, Post::find($post->id));

                    event(new PostCreated(Post::find($post->id)));
                }

                return response()->json([
                    'data' => Post::find($post->id),
                    'message' => 'Success',
                ], 201);
            }
                return response()->json([
                    'message' => 'O Titulo ou a descrição contem palavras proibidas.'
                ], 400);

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
            $post = Post::find($id);

            if(is_null($post)){
                return response()->json(['message' => "Post not found!"], 404);
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $post = Post::find($id);

            $forbiddenWords = ForbiddenWord::all()->pluck('name')->toArray();

            $rawTitle = explode(" ", $request->title);
            $rawDescription = explode(" ", $request->description);

            $title = StringUtility::remove_multiple_utf8($rawTitle);
            $description = StringUtility::remove_multiple_utf8($rawDescription);

            $diffDescription = array_diff($description,$forbiddenWords);
            $diffTitle = array_diff($title,$forbiddenWords);

            if(sizeof($diffTitle) == sizeof($title) && sizeof($diffDescription) == sizeof($description)) {
                $post->title = $request->title;
                $post->description = $request->description;
                $post->user_id = $request->user_id;
                $post->post_type_id = $request->post_type_id;
                $post->save();


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
            }
            return response()->json([
                'message' => 'O Titulo ou a descrição contem palavras proibidas.'
            ], 400);

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

            if(is_null($post)){
                return response()->json(['message' => "Post not found!"], 404);
            }

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
