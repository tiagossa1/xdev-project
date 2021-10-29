<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Requests\CreateFeedBackRequest;
use App\Http\Requests\UpdateFeedBackRequest;
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
                'data' => Feedback::all(),
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
    public function store(CreateFeedBackRequest $request)
    {
        try {
            $feedback = Feedback::create($request->all());

            return response()->json([
                'data' => $feedback,
                'message' => 'Success',
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
    public function show($id)
    {
        try {
            $feedback = Feedback::find($id);

            if(is_null($feedback)){
                return response()->json(['message' => "Feedback not found!"], 404);
            }

            return response()->json([
                'data' => Feedback::find($id),
                'message' => 'Success',
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
    public function update(UpdateFeedBackRequest $request, $id)
    {
        try {
            $feedback = Feedback::find($id);
            $feedback->update($request->all());

            return response()->json([
                'data' => $feedback->load('user', 'feedback_type'),
                'message' => 'Success',
            ], 200);

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
    public function destroy($id)
    {
        try {
            $feedback = Feedback::find($id);

            if(is_null($feedback)){
                return response()->json(['message' => "Feedback not found!"], 404);
            }

            $feedback->delete();
            return response()->json(['message' => 'Deleted'], 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
