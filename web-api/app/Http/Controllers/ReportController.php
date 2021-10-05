<?php

namespace App\Http\Controllers;

use App\Report;
use Exception;
use Illuminate\Http\Request;

class ReportController extends Controller
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
                'data' => Report::with('user', 'post', 'comments')->get(),
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
            $report = Report::create($request->all());

            if ($request->input('users') != null)
                $report->users()->sync($request->input('users'));

            if ($request->input('posts') != null)
                $report->posts()->sync($request->input('posts'));

            if ($request->input('postComments') != null)
                $report->postComments()->sync($request->input('postComments'));

            if ($request->input('reportConclusions') != null)
                $report->reportConclusions()->sync($request->input('reportConclusions'));

            return response()->json([
                'data' => $report,
                'message' => 'Success',
            ], 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Report $report
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Report $report)
    {
        try {
            return response()->json([
                'data' => $report->load('user', 'post', 'comments'),
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
     * @param \App\Report $report
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Report $report)
    {
        try {
            $report->update($request->all());

            if ($request->input('users') != null)
                $report->users()->sync($request->input('users'));

            if ($request->input('posts') != null)
                $report->posts()->sync($request->input('posts'));

            if ($request->input('postComments') != null)
                $report->postComments()->sync($request->input('postComments'));

            if ($request->input('reportConclusions') != null)
                $report->reportConclusions()->sync($request->input('reportConclusions'));

            return response()->json([
                'data' => $report,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Report $report
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Report $report)
    {
        try {
            $report->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
