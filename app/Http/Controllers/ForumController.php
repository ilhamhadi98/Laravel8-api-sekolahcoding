<?php

namespace App\Http\Controllers;

// use AuthUserTrait;
use App\Models\Forum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthUserTrait;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    use AuthUserTrait;

    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function index()
    {
        //
        return Forum::with('user:id,username')->paginate(3);
    }

    public function store(Request $request)
    {
        //
        $this->validateRequest();

        $user = $this->getAuthUser();

        $user->forums()->create(
            [
                'title' => request('title'),
                'body' => request('body'),
                'slug' => Str::slug(request('title')) . '-' . time(),
                'category' => request('category'),
            ]
        );

        return response()->json(['message' => 'Post Successfully Submitted']);
    }

    public function show($id)
    {
        //
        return Forum::with('user:id,username', 'comments.user:id,username')->find($id);

        // get all comments too
    }

    public function update(Request $request, $id)
    {
        //
        $this->validateRequest();

        $forum = Forum::find($id);

        $this->checkOwnerShip($forum->user_id);

        $forum->update(
            [
                'title' => request('title'),
                'body' => request('body'),
                'category' => request('category'),
            ]
        );

        return response()->json(['message' => 'Post Successfully Updated']);
    }

    private function validateRequest()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'category' => 'required'
        ]);

        if ($validator->fails()) {
            response()->json($validator->messages())->send();
            exit;
        }
    }

    public function destroy($id)
    {
        $forum = Forum::find($id);

        $this->checkOwnerShip($forum->user_id);

        $forum->delete();

        return response()->json(['message' => 'Post has been deleted!']);
    }
}
