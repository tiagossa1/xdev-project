<?php

namespace App\Http\Controllers;

use App\ForbiddenWord;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Utilities\StringUtility;

class ForbiddenWordController extends Controller
{
    public function index()
    {
        try {
            $forbiddenWords = ForbiddenWord::all();

            foreach ($forbiddenWords as $word) {
                $word->name = StringUtility::remove_utf8($word->name);
            }

            return response()->json([
                'data' => $forbiddenWords,
                'message' => 'Success',
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
