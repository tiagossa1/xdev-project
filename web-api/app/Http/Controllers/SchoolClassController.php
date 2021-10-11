<?php

namespace App\Http\Controllers;

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
                'data' => SchoolClass::with('school')->get(),
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
     * @param \App\SchoolClass $schoolClass
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SchoolClass $schoolClass)
    {
        try {
            return response()->json([
                'data' => $schoolClass->load('school'),
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
     * @param \App\SchoolClass $schoolClass
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        try {
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
