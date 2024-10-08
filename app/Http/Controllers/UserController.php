<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumni;
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
        // $user->load('alumni.jenjang_pendidikan');
        $user->load(['alumni.jenjang_pendidikan' => function($query) {
            $query->orderBy('created_at', 'asc'); // Mengambil jenjang pendidikan paling awal
        }]);

        $alumni = $user->alumni;
        if ($alumni && $alumni->jenjang_pendidikan->isNotEmpty()) {
            // Ambil angkatan dari jenjang pendidikan pertama
            $alumni->angkatan = $alumni->jenjang_pendidikan->first()->angkatan;
            $alumni->jurusan = $alumni->jenjang_pendidikan->first()->jurusan;
        }

        // this will NOT affect regular request, only for admin
        if ($request->admincheck) {
            $user->makeVisible('is_admin');
        }

        $response = [
            'message' => 'success',
            'data' => $user,
        ];

        return response()->json($response, 200);
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

    public function delete(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan atau tidak terautentikasi.',
            ], 404);
        }

        // Cek apakah ada alumni dengan id_user terkait
        Alumni::where('id_user', $user->id_user)->exists()
            ? Alumni::where('id_user', $user->id_user)->update(['id_user' => null])
            : null;

        // Hapus user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus',
        ], 200);
    }

    public function update(Request $request)
    {

        $v = Validator::make($request->all(), [
            'avatar' => 'max:2048|mimes:jpeg,jpg,png',
            'email' => 'email',
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

        // $request->email ? $user->email = $request->email : null;

        if ($request->email) {
            $emailExist = User::where('email', $request->email)->where('id_user', '!=', $user->id_user)->exists();
            if ($emailExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah digunakan',
                ], 422);
            }
            $user->email = $request->email;
        }

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
        if ($user->is_admin) {
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
