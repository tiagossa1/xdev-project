<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
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
                'data' => User::with('posts', 'feedbacks', 'reports', 'district')->get(),
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*    public function store(Request $request)
        {
            try {
                $user = User::create($request->all());

                $user->posts()->async($request->input('posts'));
                $user->feedbacks()->async($request->input('feedbacks'));
                $user->reports()->async($request->input('reports'));
                $user->tags()->async($request->input('tags'));

                return response()->json([
                    'data' => $user,
                    'message' => 'Success'
                ], 201);

            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }
        }*/

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        try {
            return response()->json($user->load('reports', 'posts', 'feedbacks', 'district', 'tags'), 200);
        } catch (Exception $exception) {
            return  response()->json(['error' => $exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        try {
            $user->update($request->all());

            $user->posts()->async($request->input('posts'));
            $user->feedbacks()->async($request->input('feedbacks'));
            $user->reports()->async($request->input('reports'));
            $user->tags()->async($request->input('tags'));

            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Deleted'], 205);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
