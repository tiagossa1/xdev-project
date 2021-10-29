<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostTypeRequest;
use App\Http\Requests\UpdatePostTypeRequest;
use App\PostType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostTypeController extends Controller
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
                'data' => Cache::remember('post-types',60*60*24, function (){
                    return PostType::all();
                }),
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
    public function store(CreatePostTypeRequest $request)
    {
        try {
            $postType = PostType::create($request->all());

            return response()->json([
                'data' => $postType,
                'message' => 'Success'
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
            $postType = PostType::find($id);

            if(is_null($postType)){
                return response()->json(['message' => "Comment not found!"], 404);
            }

            return response()->json([
                'data' => $postType,
                'message' => 'Success'
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
    public function update(UpdatePostTypeRequest $request, $id)
    {
        try {
            $postType = PostType::find($id);
            $postType->update($request->all());

            return response()->json([
                'data' => $postType,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PostType $postType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PostType $postType)
    {
        try {
            $postType->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
