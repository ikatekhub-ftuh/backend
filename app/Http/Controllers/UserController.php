<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get(Request $request) {
        $user = $request->user();

        return response()->json([
            'message' => 'success',
            'data' => $user
        ], 200);
    }
    
    public function changeAvatar() {
    }
}
