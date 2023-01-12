<?php

namespace App\Http\Controllers;

// use AuthUserTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AuthUserTrait;


class ForumCommentController extends Controller
{
    use AuthUserTrait;

    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function store(Request $request, $forumId)
    {
        $this->validateRequest();

        $user = $this->getAuthUser();

        $user->forumComments()->create(
            [
                'body' => request('body'),
                'forum_id' => $forumId
            ]
        );

        return response()->json(['message' => 'Post Successfully Comment Submitted']);
    }

    private function validateRequest()
    {
        $validator = Validator::make(request()->all(), [
            'body' => 'required|min:10'
        ]);

        if ($validator->fails()) {
            response()->json($validator->messages())->send();
            exit;
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
