<?php

namespace App\Http\Controllers;

use App\Feedback;
use Exception;
use Illuminate\Http\Request;

class FeedbackController extends Controller
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
                'data' => Feedback::with('feedbackType', 'users')->get(),
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
            $feedback = Feedback::create($request->all());

            $feedback->users()->attach($request->input('users'));
            $feedback->feedbackTypes()->attach($request->input('feedbackTypes'));

            return response()->json([
                'data' => $feedback,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Feedback $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Feedback $feedback)
    {
        try {
            return response()->json([
                'data' => $feedback->load('feedbackTypes', 'users'),
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Feedback $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Feedback $feedback)
    {
        try {
            $feedback->update($request->all());

            $feedback->users()->sync($request->input('users'));
            $feedback->feedbackTypes()->sync($request->input('feedbackTypes'));

            return response()->json([
                'data' => $feedback,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Feedback $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Feedback $feedback)
    {
        try {
            $feedback->delete();
            return response()->json(['message' => 'Deleted'], 205);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
