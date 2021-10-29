<?php

namespace App\Http\Controllers;

use App\FeedbackType;
use App\Http\Requests\CreateFeedBackTypeRequest;
use App\Http\Requests\UpdateFeedBackTypeRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
                'data' => Cache::remember('feedback-types',60*60*24, function (){
                    return FeedbackType::all();
                }),
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
            $feedbackType = FeedbackType::find($id);

            if(is_null($feedbackType)){
                return response()->json(['message' => "FeedbackType not found!"], 404);
            }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFeedBackTypeRequest $request, $id)
    {
        try {
            $feedbackType = FeedbackType::find($id);
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
