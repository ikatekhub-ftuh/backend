<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $user = $request->user();
        $user->load('alumni');

        return response()->json([
            'message' => 'success',
            'data' => $user
        ], 200);
    }

    // public function updateAvatar(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'avatar' => 'required|max:2048|mimes:jpeg,jpg,png',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $validator->errors(),
    //         ], 422);
    //     }
    //     $user = $request->user();

    //     if ($user->avatar) {
    //         Storage::disk('public')->delete($user->avatar);
    //     }
    //     $url = $request->file('avatar')->store('avatar/user', 'public');
    //     $user->avatar = $url;
    //     $user->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil memperbaharui avatar',
    //         'avatar' => $url
    //     ]);
    // }

    public function update(Request $request)
    {

        $v = Validator::make($request->all(), [
            'avatar' => 'max:2048|mimes:jpeg,jpg,png',
            'email' => 'email|unique:users,email',
            // old_password wajib diisi jika password diisi
            'old_password' => 'required_with:password',
            // password perlu password_confirmation jika diisi
            'password' => 'confirmed|min:8|required_with:old_password',
        ]);

        if (collect($request->all())->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Request tidak boleh kosong',
            ], 422);
        }

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors(),
            ], 422);
        }

        $user = $request->user();

        if ($request->password) {
            if (!password_verify($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sesuai',
                ], 422);
            }
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $url = $request->file('avatar')->store('avatar/user', 'public');
            User::find($user->id_user)->update([
                'avatar' => $url,
            ]);
        }

        $request->email ? $user->email = $request->email : null;

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbaharui profile',
            'data' => $user,
        ]);
    }


    public function banUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
            'banned_reason' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $user = User::find($request->id_user);
        if($user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa banned admin',
            ], 422);

        }
        $user->is_banned = true;
        $user->ban_reason = $request->banned_reason;
        $user->banned_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Banned user berhasil',
            'data' => $user,
        ]);
    }


    public function unBanUser(Request $request)
    {
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
        $user->is_banned = false;
        $user->ban_reason = null;
        $user->banned_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Unbanned user berhasil',
            'data' => $user,
        ]);
    }
}
