<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserTypeRequest;
use App\UserType;
use Exception;
use Illuminate\Http\Request;

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
                'data' => UserType::all(),
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
    public function store(CreateUserTypeRequest $request)
    {
        try {
            $userType = UserType::create($request->all());

            return response()->json([
                'data' => $userType,
                'message' => 'Success'
            ], 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\UserType $userType
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserType $userType)
    {
        try {
            return response()->json([
                'data' => $userType,
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
     * @param \App\UserType $userType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, UserType $userType)
    {
        try {
            $userType->update($request->all());

            return response()->json([
                'data' => $userType,
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UserType $userType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserType $userType)
    {
        try {
            $userType->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
