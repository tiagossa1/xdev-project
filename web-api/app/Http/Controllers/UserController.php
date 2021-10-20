<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'data' => User::orderBy('name')->get(),
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return  response()->json(['error' => $exception->getMessage()], 500);
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
                $user = User::find($request->id);

                $user->name = $request->name;
                $user->github_url = $request->github_url;
                $user->linkedin_url = $request->linkedin_url;
                $user->facebook_url = $request->facebook_url;
                $user->instagram_url = $request->instagram_url;
                $user->suspended = $request->suspended;
                $user->password = bcrypt($request->password);
                $user->save();

                $user->tags()->sync($request->input('tags'));
                $user->favorite_posts()->sync($request->input('favorite_posts'));
                $user->liked_posts()->sync($request->input('liked_posts'));

                return response()->json([
                    'data' => $user,
                    'message' => 'Sucess'
                ], 200);
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
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if(!is_null($user)) {
                $user->delete();
            }

            return response()->json(['message' => 'Deleted'], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
