<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSchoolClassRequest;
use App\Http\Requests\UpdateSchoolClassRequest;
use App\School;
use App\SchoolClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
                'data' => Cache::remember('school-classes',60*60*24, function (){
                    return SchoolClass::all();
                }),
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
            $schoolClass = SchoolClass::find($id);

            if(is_null($schoolClass)){
                return response()->json(['message' => "SchoolClass not found!"], 404);
            }

            return response()->json([
                'data' => $schoolClass,
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
    public function update(UpdateSchoolClassRequest $request, $id)
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
