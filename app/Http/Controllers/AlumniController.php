<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    public function get(Request $request)
    {
        $query = Alumni::query();

        if ($request->has('id_alumni')){
            $query->where('id_alumni', $request->id_alumni);
            $result = $query->first();

            if (!$result) {
                return response()->json([
                    'message' => 'error',
                    'errors' => 'Data not found'
                ], 404);
            }
            
            return response()->json([
                'message' => 'success',
                'request' => $request->all(),
                'data' => $result
            ], 200);
        }
        
        if ($request->has('angkatan') && $request->has('jurusan')){
            $query->where('angkatan', $request->angkatan)->where('jurusan', $request->jurusan);
            $result = $query->get();
            return response()->json([
                'message' => 'success',
                'request' => $request->all(),
                'data' => $result
            ], 200);}
        
        if ($request->has('angkatan')){
            $query->where('angkatan', $request->angkatan);
            $result = $query->select('jurusan')->selectRaw('count(*) as total')->groupBy('jurusan')->get();
            return response()->json([
                'message' => 'success',
                'request' => $request->all(),
                'data' => $result
            ], 200);
        }
        
        $result = $query->get();

        $userId = Auth::id();
        $angkatan = User::with('alumni')->find($userId)->alumni->angkatan;
        $countAngkatan = Alumni::where('angkatan', $angkatan)->count();
        
        return response()->json([
            'message' => 'success',
            'data' => [
                'angkatan' => $angkatan,
                'count'    => $countAngkatan,
            ]
            // 'alumni_user' => $user,
        ], 200);
    }

    public function post(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nim' => 'required|string',
            'tgl_lahir' => 'required|date',
            'jurusan' => 'required',
            'angkatan' => 'required|min:4|max:4',
            'kelamin' => 'required|string|max:2',
            'agama' => 'required',
            'golongan_darah' => '',
            'no_telp' => 'max:20',
        ]);
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $user = Auth::user();
        $validatedData = $validator->validated();

        $validatedData['validated'] = false;
        if( $user->is_admin ) {
            $validatedData['validated'] = true;
        } else {
            $validatedData['id_user'] = $user->id_user;
        }

        $alumni = Alumni::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data alumni',
            'data' => $alumni
        ], 201);
    }

    public function postManyDataAlumni(Request $request) {
        $validator = Validator::make($request->all(), [
            'data.*.nama' => 'required|string',
            'data.*.nim' => 'required|string',
            'data.*.tgl_lahir' => 'required|date',
            'data.*.jurusan' => 'required',
            'data.*.angkatan' => 'required|min:4|max:4',
            'data.*.kelamin' => 'required|string|max:2',
            'data.*.agama' => 'required',
            'data.*.golongan_darah' => '',
            'data.*.no_telp' => 'max:20',
        ]);
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $user = Auth::user();
        $validatedData = $validator->validated();
        $validatedData['validated'] = true;

        $alumni = Alumni::createMany($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data alumni',
            'data' => $alumni
        ], 201);
    }

    public function delete($id_alumni)
    {
        $alumni = Alumni::find($id_alumni);

        if ( !$alumni ) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan.'
            ], 404);
        }

        $alumni->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data alumni.'
        ], 200);
    }

    public function claimDataALumniByUserId(Request $request) {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required|string',
        ]);
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $alumni = Alumni::find($request->id_alumni);
        if( !$alumni ) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan',
            ], 400);
        }
        
        $user = Auth::user();
        if ( $alumni->id_user != null && !$user->is_admin ) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni sudah diklaim pengguna lain',
            ], 401);
        }

        $alumni->update([
            'id_user'=> $user->id_user,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data alumni berhasil diklaim.',
            'data'      => $alumni,
        ], 200);
    }
}
