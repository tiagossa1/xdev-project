<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
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
                'data' => District::all(),
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $district = District::create($request->all());

            return response()->json([
                'data' => $district,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\District $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        try {
            return response()->json(['data' => $district,
                'message' => 'Success'], 201);


        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\District $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        //
        try {
            $district->update($request->all());

            return response()->json([
                'data' => $district,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\District $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
        try {
            $district->delete();
            return response()->json(['message' => 'Deleted'], 205);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception], 500);
        }
    }
}
