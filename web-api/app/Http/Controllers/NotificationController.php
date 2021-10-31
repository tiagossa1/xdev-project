<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'data' => auth()->user()->unreadNotifications,
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use($request) {
            return $query->where('id', $request->input('id'));
        })->markAsRead();

        return response()->json(['message' => 'Marked as read.', 200]);
    }
}
