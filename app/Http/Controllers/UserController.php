<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function get(Request $request) {
          $user = $request->user();

          return response()->json([
              'message' => 'success',
              'data' => $user
          ], 200);
      }

      
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

    public function bannedUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'banned_reason' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }
        
        $user = User::find($request->id_user);
        $user->update([
            'is_banned' => true,
            'ban_reason' => $request->banned_reason,
            'banned_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banned user berhasil',
        ]);
    }

    public function unBannedUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }
        
        $user = User::find($request->id_user);
        $user->update([
            'is_banned' => false,
            'ban_reason' => null,
            'banned_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unbanned user berhasil',
        ]);
    }
}
