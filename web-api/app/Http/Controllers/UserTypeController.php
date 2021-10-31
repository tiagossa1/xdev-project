<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserTypeRequest;
use App\Http\Requests\UpdateUserTypeRequest;
use App\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserTypeController extends Controller
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
                'data' => Cache::remember('user-types', 60 * 60 * 24, function () {
                    return UserType::all();
                }),
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
    public function store(CreateUserTypeRequest $request)
    {
        try {
            $userType = UserType::create($request->all());

            return response()->json([
                'data' => $userType,
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
            $userType = UserType::find($id);

            if (is_null($userType)) {
                return response()->json(['message' => "UserType not found!"], 404);
            }

            return response()->json([
                'data' => $userType,
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
    public function update(UpdateUserTypeRequest $request, $id)
    {
        try {
            $userType = UserType::find($id);
            $userType->update($request->all());

            return response()->json([
                'data' => $userType->fresh(),
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UserType $userType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $userType = UserType::find($id);

            if (is_null($userType)) {
                return response()->json(['message' => "UserType not found!"], 404);
            }

            $userType->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
