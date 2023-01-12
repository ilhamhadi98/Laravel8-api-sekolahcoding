<?php

namespace App\Http\Controllers;

// use AuthUserTrait;
use App\Models\Forum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthUserTrait;
use App\Models\ForumComment;
use Illuminate\Support\Facades\Validator;


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

        return response()->json(['message' => 'Comment Successfully Submitted']);
    }

    private function validateRequest()
    {
        $validator = Validator::make(request()->all(), [
            'body' => 'required|min:10'
        ]);

        if ($validator->fails()) {
            response()->json($validator->messages(), 422)->send();
            exit;
        }
    }

    public function update(Request $request, $forumId, $commentId)
    {
        $this->validateRequest();

        $forumComment = ForumComment::find($commentId);

        $this->checkOwnerShip($forumComment->user_id);

        $forumComment->update(
            [
                'body' => request('body')
            ]
        );

        return response()->json(['message' => 'Comment Successfully Updated']);
    }

    public function destroy($forumId, $commentId)
    {
        $forumComment = ForumComment::find($commentId);

        $this->checkOwnerShip($forumComment->user_id);

        $forumComment->delete();

        return response()->json(['message' => 'Comment has been deleted!']);
    }
}
