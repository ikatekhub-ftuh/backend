<?php

namespace App\Http\Controllers;

use App\Helpers\AlumniHelper;
use App\Models\Alumni;
use App\Models\Jurusan;
use App\Models\User;
use Carbon\Carbon;
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
            if(Alumni::find($user->id_user)) {
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
    
    public function uploadData(Request $request) {
        $file = $request->file('file_alumni');
        $fileContents = file($file->getPathname());
        array_shift($fileContents);
        
        $timeNow = Carbon::now();
        
        $dataFile = [];
        $alumniCounts = Alumni::select('angkatan', 'jurusan', Alumni::raw('count(*) as total'))
                    ->where('validated', true)
                    ->groupBy('angkatan', 'jurusan')
                    ->get()
                    ->keyBy(function ($item) {
                        return $item['jurusan'] . '-' . $item['angkatan'];
                    });

        $jurusan = Jurusan::select('nama_jurusan', 'kode_jurusan')->get();

        $i = 0;
        foreach ($fileContents as $line) {
            $data = str_getcsv($line, ";");
                
                $no_anggota = AlumniHelper::generateNoAnggota($request->jurusan, $data[6], $alumniCounts, $jurusan);

                $dataFile[] = [
                    'nim' => $data[0],
                    'nama' => $data[1],
                    'kelamin' => strtolower($data[2]),
                    'tgl_lahir' => Date("d-m-Y", strtotime($data[3])),
                    'agama' => $data[4],
                    'no_telp' => AlumniHelper::getNomorTelepon($data[5]),
                    'angkatan' => $data[6],
                    'jurusan' => $request->jurusan ?? 'TEKNIK INFORMATIKA',
                    'no_anggota' => $no_anggota,
                    'validated' => true,
                    'created_at' => $timeNow,
                    'updated_at' => $timeNow,
                ];
            $i++;
            if($i == 1000) break;
        }
        $validator = Validator::make($dataFile, [
            '*.nama' => 'required|string',
            '*.nim' => 'required|string|unique:alumni,nim|unique:App\Models\Alumni,nim',
            '*.tgl_lahir' => 'required|date',
            '*.jurusan' => 'required|string',
            '*.angkatan' => 'required|string|max:4',
            '*.kelamin' => 'required|string|in:l,p',
            '*.agama' => 'required|string|in:Islam,Kristen Protestan,Kristen Katolik,Hindu,Buddha,Konghucu',
            '*.golongan_darah' => 'nullable|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            '*.no_telp' => 'nullable|string|max:20',
        ]);
        
        if ($validator->fails()) {
            // Mendapatkan pesan error
            $errors = $validator->errors()->toArray();

            // Menggabungkan data yang tidak valid dengan error
            $invalidData = [];
            foreach ($dataFile as $index => $data) {
                $invalidData[] = [
                    'coba' => $data,
                ];
                if (isset($errors[$index])) {
                    $invalidData[] = [
                        'data' => $data,
                        'errors' => $errors[$index],
                    ];
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Beberapa data tidak valid',
                'invalid_data' => $invalidData,  // Data yang tidak valid beserta pesan error
                'errors' => $errors
            ], 400);
        }


        Alumni::insert($dataFile);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data alumni',
            'data' => $dataFile,
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
        
        if(Alumni::find($user->id_user)) {
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
