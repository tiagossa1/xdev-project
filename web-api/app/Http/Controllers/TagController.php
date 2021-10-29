<?php

namespace App\Http\Controllers;

use App\ForbiddenWord;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Tag;
use App\Utilities\StringUtility;
use Exception;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Tag::withCount([
<<<<<<< Updated upstream
                'posts as posts_count' => function ($query) {
                    $query->where('suspended', 0);
                }
            ]);

            // $query = Tag::withCount('posts')->with('posts')->orderBy('posts_count', 'desc');
=======
                'posts as post_count' => function ($query) {
                    $query->where('suspended', 0);
                }]);

>>>>>>> Stashed changes
            $count = $request->count;

            if (!is_null($count)) {
                $query->take($count);
            }

            return response()->json([
                'data' => $query->get(),
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
    public function store(CreateTagRequest $request)
    {
        try {
            $forbiddenWords = ForbiddenWord::all()->pluck('name')->toArray();

            $rawName = explode(" ", $request->name);

            $name = StringUtility::remove_multiple_utf8($rawName);

            $diffDescription = array_diff($name, $forbiddenWords);

            if (sizeof($diffDescription) == sizeof($name)) {
                $tag = new Tag();
                $tag->name = $request->name;
                $tag->save();

                return response()->json([
                    'data' => Tag::find($tag->id),
                    'message' => 'Success'
                ], 201);
            }

            return response()->json([
                'message' => 'Tag com palavra proibida'
            ], 400);
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
            $tag = Tag::find($id);

            if(is_null($tag)){
                return response()->json(['message' => "Tag not found!"], 404);
            }

            return response()->json([
                'data' => $tag,
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
    public function update(UpdateTagRequest $request, $id)
    {
        try {
            $tag = Tag::find($id);
            $tag->update($request->all());

            return response()->json([
                'data' => $tag->fresh(),
                'message' => 'Success'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Tag $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $tag = Tag::find($id);

            if(is_null($tag)){
                return response()->json(['message' => "Tag not found!"], 404);
            }

            $tag->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function getOrCreateTags(Request $request)
    {
        $request->validate([
            'tags' => 'required'
        ]);

        $tags = [];

        foreach ($request->tags as $tagName) {
            $tagWithoutUtf8 = StringUtility::remove_utf8($tagName);

            $tagRecord = Tag::whereRaw('LOWER(name) LIKE ?', [$tagWithoutUtf8])->first();
            $isForbidden = ForbiddenWord::whereRaw('LOWER(name) LIKE ?', [$tagWithoutUtf8])->exists();

            if ($tagRecord !== null) {
                array_push($tags, $tagRecord);
            } else if (!$isForbidden) {
                $newTag = new Tag();
                $newTag->name = $tagName;
                $newTag->save();

                array_push($tags, $newTag);
            }
        }

        return response()->json([
            'data' => $tags,
            'message' => 'Success'
        ]);
    }
}
