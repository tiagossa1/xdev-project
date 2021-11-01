<?php

namespace App\Http\Controllers;

use Exception;
use App\Comment;
use App\ForbiddenWord;
use Illuminate\Http\Request;
use App\Utilities\StringUtility;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Validation\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json([
                'data' => Comment::all(),
                'message' => 'Success',
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request)
    {
        try {
            $forbiddenWords = ForbiddenWord::all()->pluck('name')->toArray();

            $rawDescription = explode(" ", mb_strtolower($request->description));
            //return response()->json([$rawDescription,$forbiddenWords]);

            $description = StringUtility::remove_multiple_utf8($rawDescription);

            $diffDescription = array_diff($description, $forbiddenWords);

            if (sizeof($diffDescription) == sizeof($description)) {
                $comment = new Comment();
                $comment->description = $request->description;
                $comment->user_id = $request->user_id;
                $comment->post_id = $request->post_id;
                $comment->save();

                return response()->json([
                    'data' => $comment->load('user'),
                    'message' => 'Success',
                ], 201);
            }
            return response()->json([
                'message' => 'Descrição com palavra proibida'
            ], 400);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $comment = Comment::find($id);

            if (is_null($comment)) {
                return response()->json(['message' => "Comment not found!"], 404);
            }

            return response()->json([
                'data' => $comment,
                'message' => 'Success',
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        try {
            $comment = Comment::find($id);

            $forbiddenWords = ForbiddenWord::all()->pluck('name')->toArray();

            $rawDescription = explode(" ", mb_strtolower($request->description));

            $description = StringUtility::remove_multiple_utf8($rawDescription);

            $diffDescription = array_diff($description, $forbiddenWords);

            if (sizeof($diffDescription) == sizeof($description)) {
                $comment->description = $request->description;
                $comment->user_id = $request->user_id;
                $comment->post_id = $request->post_id;
                $comment->save();

                return response()->json([
                    'data' => $comment,
                    'message' => 'Success',
                ], 200);
            }
            return response()->json([
                'message' => 'Descrição com palavra proibida'
            ], 400);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);

            if (is_null($comment)) {
                return response()->json(['message' => "Comment not found!"], 404);
            }

            $comment->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
