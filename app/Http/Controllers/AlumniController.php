<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Jurusan;
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
            'nama'              => 'required|string',
            'nim'               => 'required|string',
            'tgl_lahir'         => 'required|date',
            'jurusan'           => 'required',
            'angkatan'          => 'required|min:4|max:4',
            'kelamin'           => 'required|string|max:2',
            'agama'             => 'required',
            'golongan_darah'    => '',
            'no_telp'           => 'max:20',
        ]);
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => implode('\n', $validator->errors()->all()),
            ], 400);
        }

        $user = Auth::user();
        
        $validatedData = $validator->validated();
        $validatedData['validated'] = false;
        if( $user->is_admin ) {
            $validatedData['validated'] = true;
        } else {
            if(!Alumni::find($user->id_user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah memiliki data alumni',
                ], 400);
            }
            $validatedData['id_user'] = $user->id_user;
        }

        $alumni = Alumni::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data alumni',
            'data' => $alumni
        ], 201);
    }

    // public function postManyDataAlumni(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'data.*.nama' => 'required|string',
    //         'data.*.nim' => 'required|string',
    //         'data.*.tgl_lahir' => 'required|date',
    //         'data.*.jurusan' => 'required',
    //         'data.*.angkatan' => 'required|min:4|max:4',
    //         'data.*.kelamin' => 'required|string|max:2',
    //         'data.*.agama' => 'required',
    //         'data.*.golongan_darah' => '',
    //         'data.*.no_telp' => 'max:20',
    //     ]);
    //     if ( $validator->fails() ) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $validator->errors(),
    //         ], 400);
    //     }

    //     $user = Auth::user();
    //     $validatedData = $validator->validated();
    //     $validatedData['validated'] = true;

    //     $alumni = Alumni::createMany($validatedData);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Berhasil menambahkan data alumni',
    //         'data' => $alumni
    //     ], 201);
    // }
    
    public function uploadData(Request $request) {
        $file = $request->file('file_alumni');
        $fileContents = file($file->getPathname());
        
        // array untuk menampung isi file berupa nama, jurusan
        $dataFile = [];
        $alumni = Alumni::select('angkatan', 'jurusan', Alumni::raw('count(*) as total'))
                    ->where('validated', true)
                    ->groupBy('angkatan', 'jurusan')
                    ->get()
                    ->keyBy(function ($item) {
                        return $item['jurusan'] . '-' . $item['angkatan'];
                    });

        $jurusan = Jurusan::select('nama_jurusan', 'kode_jurusan')->get();

        foreach ($fileContents as $line) {
            $data = str_getcsv($line);
            
            
            // Pastikan data memiliki dua elemen: nama dan jurusan
            if (count($data) === 8) {
                $key = $data[1] . '-' . $data[6]; // Membuat kunci unik berdasarkan jurusan dan angkatan
        
                // Periksa apakah kunci ini sudah ada dalam data alumni
                if (isset($alumni[$key])) {
                    $alumni[$key]->total += 1; // Tambahkan 1 jika sudah ada
                } else {
                    $alumni[$key] = (object)['total' => 1]; // Mulai dari 1 jika belum ada
                }

                $no_anggota = $jurusan->where('nama_jurusan', $data[1])->first()->kode_jurusan 
                                . substr($data[6], -2)
                                . str_pad($alumni[$key]->total, 3, '0', STR_PAD_LEFT);

                // $no_anggota = $data[1];
                $dataFile[] = [
                    'nama' => $data[0],
                    'jurusan' => $data[1], //tgllahir, kelamin, agama, no telp, angkatan, jurusan
                    'tanggal_lahir' => $data[2],
                    'kelamin' => $data[3],
                    'agama' => $data[4],
                    'no_telpon' => $data[5],
                    'angkatan' => $data[6],
                    'no_anggota' => $no_anggota,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data alumni',
            'data' => $dataFile,
            'alumni' => $alumni,
            // 'fileContents' => $fileContents,
            // 'jurusan' => $jurusan,
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
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required',
            'id_user' => $user->is_admin ? 'required' : '', 
        ]);
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => implode('\n',$validator->errors()->all()),
            ], 400);
        }
        
        if(!Alumni::find($user->id_user)) {
            return response()->json([
                'success' => false,
                'message' => 'User sudah memiliki data alumni',
            ], 400);
        }

        $alumni = Alumni::find($request->id_alumni);
        if( !$alumni ) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan',
            ], 400);
        }
        
        if ( $alumni->id_user != null && !$user->is_admin ) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni sudah diklaim pengguna lain',
            ], 401);
        }

        $alumni->update([
            'id_user'=> $user->is_admin ? $request->id_user : $user->id_user,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data alumni berhasil diklaim.',
            'data'      => $alumni,
        ], 200);
    }

    public function validateDataAlumni(Request $request) {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => implode("\n", $validator->errors()->all()),
            ], 400);
        }

        $alumni = Alumni::find($request->id_alumni);
        if( !$alumni ) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan',
            ], 400);
        }
        $alumni->update([
            'validated'=> true,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data alumni berhasil divalidasi.',
            'data'      => $alumni,
        ], 200);        
    }
}
