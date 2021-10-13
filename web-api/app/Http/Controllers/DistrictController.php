<?php

namespace App\Http\Controllers;

use App\District;
use App\Http\Requests\CreateDistrictRequest;
use Exception;
use Illuminate\Http\Request;

class DistrictController extends Controller
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
                'data' => District::all(),
                'message' => 'Success',
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
    public function store(CreateDistrictRequest $request)
    {
        try {
            $district = District::create($request->all());

            return response()->json([
                'data' => $district,
                'message' => 'District created with success',
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\District $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(District $district)
    {
        try {
            return response()->json(['data' => $district,
                'message' => 'Success'], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\District $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, District $district)
    {
        try {
            $district->update($request->all());

            return response()->json([
                'data' => $district,
                'message' => 'Success',
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\District $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(District $district)
    {
        try {
            $district->delete();
            return response()->json(['message' => 'Deleted'], 200);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
