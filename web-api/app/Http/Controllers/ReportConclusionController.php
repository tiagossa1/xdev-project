<?php

namespace App\Http\Controllers;

use App\ReportConclusion;
use Illuminate\Http\Request;

class ReportConclusionController extends Controller
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
                'data' => ReportConclusion::all(),
                'message' => 'Success'
            ], 200);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $reportConclusion = ReportConclusion::create($request->all());

            return response()->json([
                'data' => $reportConclusion,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReportConclusion  $reportConclusion
     * @return \Illuminate\Http\Response
     */
    public function show(ReportConclusion $reportConclusion)
    {
        try {
            return response()->json([
                'data' => $reportConclusion,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReportConclusion  $reportConclusion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportConclusion $reportConclusion)
    {
        try {
            $reportConclusion->update($request->all());

            return response()->json([
                'data' => $reportConclusion,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReportConclusion  $reportConclusion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportConclusion $reportConclusion)
    {
        try{
            $reportConclusion->delete();
            return response()->json(['message' => 'Deleted'],205);

        }catch(Exception $exception){

            return response()->json(['error' => $exception], 500);
        }
    }
}
