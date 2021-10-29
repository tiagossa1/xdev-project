<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Exception;
use App\Report;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Events\ReportCreated;
use App\Notifications\NewReport;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Support\Facades\Notification;

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
                'data' => Report::all(),
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
    public function store(ReportRequest $request)
    {
        try {
            $report = Report::create($request->all());

            if ($request->input('user') != null)
                $report->users()->sync($request->input('users'));

            if ($request->input('post') != null)
                $report->posts()->sync($request->input('posts'));

            if ($request->input('comment') != null)
                $report->comments()->sync($request->input('comments'));

            // isModerator, isSheriff and isFromTheSameClass are called scopes. They are declared on User.php (User model file).
            $moderators = User::isModerator()->where('id', '<>', Auth::user()->id)->get();

            // FIXME: Notification não funciona por causa da tabela Notification, campo data é pequeno demais para o Base64.

            // $ownerSchoolClass = Post::find($request->post_id)->user->school_class->id;
            // $sheriffs = User::isSheriff()->isFromTheSameClass($ownerSchoolClass)->get();

            // if(!is_null($moderators)) {
            //     Notification::send($moderators, new NewReport(Report::with('user', 'post', 'comment', 'moderator', 'report_conclusion')->find($report->id)));
            // }

            // if(!is_null($sheriffs)) {
            //     Notification::send($sheriffs, new NewReport(Report::with('user', 'post', 'comment', 'moderator', 'report_conclusion')->find($report->id)));
            // }

            // event(new ReportCreated($report));
            // broadcast(new ReportCreated($report));

            // $mods = User::whereIn('user_type_id', [2,4])->get();

            // if(!is_null($mods))
            //     Notification::send($mods, new NewReport(Report::with('user', 'post', 'comment', 'moderator', 'report_conclusion')->find($report->id)));

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            return response()->json([
                'data' => Report::find($id),
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
    public function update(UpdateReportRequest $request, $id)
    {
        try {
            $report = Report::find($id);
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
                'data' => $report->fresh(),
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
