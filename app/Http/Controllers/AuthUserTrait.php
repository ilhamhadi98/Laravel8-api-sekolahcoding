<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

trait AuthUserTrait
{
    private function getAuthUser()
    {
        try {
            return auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            response()->json(['message' => 'Not Authorized, Login First!'])->send();
            exit;
        }
    }

    private function checkOwnerShip($owner)
    {
        $user = $this->getAuthUser();

        // check ownership
        if ($user->id != $owner) {
            response()->json(['message' => 'Not Authorized 403'], 403)->send();
            exit;
        }
    }
}
