<?php

namespace App\Http\Controllers;

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
                'data' => PostPhoto::with('post')->get(),
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
            $postPhoto = PostPhoto::create($request->all());

            return response()->json([
                'data' => $postPhoto,
                'message' => 'Success'
            ], 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PostPhoto $postPhoto
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PostPhoto $postPhoto)
    {
        try {
            return response()->json([
                'data' => $postPhoto->load('post'),
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
     * @param \App\PostPhoto $postPhoto
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, PostPhoto $postPhoto)
    {
        try {
            $postPhoto->update($request->all());

            return response()->json([
                'data' => $postPhoto,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PostPhoto $postPhoto
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PostPhoto $postPhoto)
    {
        try {
            $postPhoto->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
