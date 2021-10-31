<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\School;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SchoolController extends Controller
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
                'data' => Cache::remember('schools', 60 * 60 * 24, function () {
                    return School::all();
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
    public function store(CreateSchoolRequest $request)
    {
        try {
            $school = School::create($request->all());

            return response()->json([
                'data' => $school,
                'message' => 'School created with success'
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
            $school = School::find($id);

            if (is_null($school)) {
                return response()->json(['message' => "School not found!"], 404);
            }

            return response()->json([
                'data' => $school,
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
    public function update(UpdateSchoolRequest $request, $id)
    {
        try {
            $school = School::find($id);
            $school->update($request->all());

            return response()->json([
                'data' => $school,
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\School $school
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $school = School::find($id);

            if (is_null($school)) {
                return response()->json(['message' => "School not found!"], 404);
            }

            $school->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
