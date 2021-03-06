<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostPhotoRequest;
use App\PostPhoto;
use Exception;
use Illuminate\Http\Request;

class PostPhotoController extends Controller
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
                'data' => PostPhoto::all(),
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePostPhotoRequest $request)
    {
        try {
            $postPhoto = PostPhoto::create($request->all());

            return response()->json([
                'data' => $postPhoto,
                'message' => 'Success'
            ], 201);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
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
            $postPhoto = PostPhoto::find($id);

            if(is_null($postPhoto)){
                return response()->json(['message' => "Comment not found!"], 404);
            }

            return response()->json([
                'data' => $postPhoto,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
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
            $postPhoto = PostPhoto::find($id);
            $postPhoto->update($request->all());

            return response()->json([
                'data' => $postPhoto,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PostPhoto $postPhoto
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $postPhoto = PostPhoto::find($id);

            if(is_null($postPhoto)){
                return response()->json(['message' => "Comment not found!"], 404);
            }

            $postPhoto->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
