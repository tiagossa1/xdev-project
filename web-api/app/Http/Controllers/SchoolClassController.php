<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSchoolClassRequest;
use App\School;
use App\SchoolClass;
use Exception;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
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
                'data' => SchoolClass::all(),
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
    public function store(CreateSchoolClassRequest $request)
    {
        try {
            $schoolClass = SchoolClass::create($request->all());

            return response()->json([
                'data' => $schoolClass,
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
            return response()->json([
                'data' => SchoolClass::find($id),
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
    public function update(Request $request, $id)
    {
        try {
            $schoolClass = SchoolClass::find($id);
            $schoolClass->update($request->all());

            return response()->json([
                'data' => $schoolClass,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SchoolClass $schoolClass
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SchoolClass $schoolClass)
    {
        try {
            $schoolClass->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
