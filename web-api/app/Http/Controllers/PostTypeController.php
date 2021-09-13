<?php

namespace App\Http\Controllers;

use App\PostType;
use Illuminate\Http\Request;

class PostTypeController extends Controller
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
                'data' => PostType::all(),
                'message' => 'Success'
            ], 200);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $postType = PostType::create($request->all());

            return response()->json([
                'data' => $postType,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostType  $postType
     * @return \Illuminate\Http\Response
     */
    public function show(PostType $postType)
    {
        try {
            return response()->json([
                'data' => $postType,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostType  $postType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostType $postType)
    {
        try {
            $postType->update($request->all());

            return response()->json([
                'data' => $postType,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostType  $postType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostType $postType)
    {
        try{
            $postType->delete();
            return response()->json(['message' => 'Deleted'],205);

        }catch(Exception $exception){

            return response()->json(['error' => $exception], 500);
        }
    }
}
