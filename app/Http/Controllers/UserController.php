<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function updateAvatar(Request $request) {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|max:4048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }
        
        $user = Auth::user();

        // Cek apakah pengguna sudah memiliki avatar
        if ($user->avatar) {
            // Hapus avatar lama dari storage
            Storage::disk('public')->delete($user->avatar);
        }

        // Upload avatar baru
        $avatar = $request->file('avatar')->storeAs(
            'avatar/user', strstr($user->email, '@', true). '-' . $user->id_user . '.' . $request->file('avatar')->getClientOriginalExtension(), 'public'
        );

        User::find($user->id_user)->update([
            'avatar' => url('/') . $avatar,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbaharui avatar',
            'avatar' => User::find($user->id_user),
        ]);
    }
}
