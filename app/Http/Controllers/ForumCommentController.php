<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForumCommentController extends Controller
{
    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function store(Request $request)
    {
        $this->validateRequest();

        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['message' => 'Not Authorized, Login First!']);
        }

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
