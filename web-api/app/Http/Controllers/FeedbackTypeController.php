<?php

namespace App\Http\Controllers;

use App\FeedbackType;
use App\Http\Requests\CreateFeedBackTypeRequest;
use Exception;
use Illuminate\Http\Request;

class FeedbackTypeController extends Controller
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
                'data' => FeedbackType::all(),
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
    public function store(CreateFeedBackTypeRequest $request)
    {
        try {
            $feedbackType = FeedbackType::create($request->all());

            return response()->json([
                'data' => $feedbackType,
                'message' => 'Success'
            ], 201);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\FeedbackType $feedbackType
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FeedbackType $feedbackType)
    {
        try {
            return response()->json([
                'data' => $feedbackType,
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
     * @param \App\FeedbackType $feedbackType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, FeedbackType $feedbackType)
    {
        try {
            $feedbackType->update($request->all());

            return response()->json([
                'data' => $feedbackType,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\FeedbackType $feedbackType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FeedbackType $feedbackType)
    {
        try {
            $feedbackType->delete();
            return response()->json(['message' => 'Deleted'], 205);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
