<?php

namespace App\Http\Controllers;

use App\Helpers\AlumniHelper;
use App\Models\Alumni;
use App\Models\StatistikPendidikan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlumniController extends Controller
{
    public function get(Request $request)
    {
        $query = Alumni::query();
        $query->where('validated', true);

        if ( $request->has('id_alumni') ) {
            $query->select('id_alumni', 'id_user', 'nim', 'no_anggota', 'nama', 'jurusan', 'angkatan', 'kelamin', 'agama', 'golongan_darah', )
                    ->where('id_alumni', $request->id_alumni);
            $alumni = $query->first();

            if ( !$alumni ) {
                return response()->json([
                    'message'   => 'error',
                    'errors'    => 'Data not found'
                ], 404);
            }
            
            $alumni->load('user');

            return response()->json([
                'message'   => 'success',
                'request'   => $request->all(),
                'data'      => $alumni
            ], 200);
        }
        
        if ( $request->has('angkatan') && $request->has('jurusan') ) {
            if($request->angkatan !== 'all') {
                $query->where('angkatan', $request->angkatan);
            }
            $query->where('jurusan',    $request->jurusan);

            if ( $request->has('search') ) {
                $query->where('nama', 'ilike', '%'.$request->search.'%');
            }

            $result = $query->get();
            return response()->json([
                'message'   => 'success',
                'request'   => $request->all(),
                'data'      => $result
            ], 200);
        }
        
        if ( $request->has('angkatan') && !$request->has('all') ) {
            if($request->angkatan !== 'all') {
                $query->where('angkatan', $request->angkatan);
            }
                  
            $query->select('jurusan')
                  ->selectRaw('count(*) as total')
                  ->groupBy('jurusan');
            
            if($request->has('search')) {
                $query->where('nama', 'ilike', '%'.$request->search.'%');
            }

            $result = $query->get();
            return response()->json([
                'message'   => 'success',
                'request'   => $request->all(),
                'data'      => $result
            ], 200);
        }

        $query->select('angkatan')
              ->selectRaw('count(*) as total')
              ->groupBy('angkatan');
        
        if( $request->has('all') && $request->all === 'false') {
            if($request->has('angkatan')) {
                $query->where('angkatan', $request->angkatan);
            } else {
                $angkatan = User::with('alumni')->find(Auth::id())->alumni->angkatan;
                $query->where('angkatan', $angkatan);
            }
        }

        if( !$request->has('all') ) {
            $angkatan = User::with('alumni')->find(Auth::id())->alumni->angkatan;
            $query->where('angkatan', $angkatan);
        }

        if($request->has('search')) {
            $query->where('nama', 'ilike', '%'.$request->search.'%');
        }

        $result = $query->get();
        
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function getDataToClaim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string',
            'tgl_lahir' => 'required|date', 
            'jurusan'   => 'required|string',
        ]);
        
        if ( $validator->fails() ) {
            return response()->json(
            [
                'success' => false,
                'message' => implode('\n',$validator->errors()->all()),
            ], 400);
        }

        $query = Alumni::query();

        $query->select('id_alumni' ,'nama', 'jurusan', 'angkatan', 'tgl_lahir', Db::raw('CASE WHEN id_user is NULL THEN false ELSE true END as is_claim'))
                      ->whereRaw('LOWER(nama) = ?',     [strtolower($request->nama)])
                      ->where('tgl_lahir',              $request->tgl_lahir)
                      ->whereRaw('LOWER(jurusan) = ?',  [strtolower($request->jurusan)]);


        $result = $query->get();
        return response()->json([
            'message'   => 'success',
            'request'   => $request->all(),
            'data'      => $result
        ], 200);
    }

    public function post(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama'              => 'required|string',
            'tgl_lahir'         => 'required|date',
            'jurusan'           => 'required|string',
            'angkatan'          => 'required|integer|digits:4',
            'kelamin'           => 'required|string|in:l,p',
            'agama'             => 'nullable',
            'nim'               => 'required_without_all:jenjang',
            'jenjang'           => 'required_without_all:nim|enum:S1,S2,S3,PPI,PPA',
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
            if( Alumni::where('id_user', $user->id_user)->first() ) {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah memiliki data alumni',
                ], 400);
            }
            $validatedData['id_user'] = $user->id_user;
            $validatedData['no_anggota'] = AlumniHelper::generateNoAnggota($request->jurusan, $request->angkatan);
        }

        $jenjang = $request->has('jenjang') 
                    ? $request->jenjang 
                    : AlumniHelper::getStrata($request->nim);

        $statistik = StatistikPendidikan::where('jenjang', $jenjang)
                        ->first();
        $statistik->jumlah += 1;
        
        $alumni = Alumni::create($validatedData);
        $statistik->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data alumni',
            'data' => $alumni
        ], 201);
    }
    
    public function update(Request $request) {// Validasi field yang mungkin akan diupdate
        $validator = Validator::make($request->all(), [
            'nama'      => 'sometimes|required|string|max:100',
            'nim'       => 'sometimes|required|string|max:20',
            'tgl_lahir' => 'sometimes|required|date',
            'jurusan'   => 'sometimes|required|string|max:100',
            'angkatan'  => 'sometimes|required|integer|digits:4',
            'no_telp'   => 'sometimes|required|max:20',
            'agama'     => 'sometimes|nullable|string|max:50',
            'kelamin'   => 'sometimes|string|in:l,p',
            'golongan_darah' => 'sometimes|nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        if ($validator->fails()) {
            $errors = implode("\n", $validator->errors()->all());
            
            return response()->json([
                'success' => false,
                'message' => $errors,
            ], 400);
        }
        
        $alumni = Alumni::where('id_user', $request->user()->id_user)->firstOrFail();
        
        $alumni->fill($request->only([
            'nama',
            'nim',
            'tgl_lahir',
            'jurusan',
            'angkatan',
            'no_telp',
            'agama',
            'kelamin',
            'golongan_darah',
        ]));
        
        $alumni->save();

        return response()->json([
            'succes'    => true,
            'message'   => 'Data user berhasil di update',
            'request'   => $request->all(),
            'data'      => $alumni,
        ], 200);
    }

    public function uploadData(Request $request) {
        $file = $request->file('file_alumni');
        $fileHandle = fopen($file->getPathname(), 'r');
        $timeNow = Carbon::now();

        // Skip header row
        fgetcsv($fileHandle, 0, ";");

        $dataFile = [];
        while (($data = fgetcsv($fileHandle, 0, ";")) !== false) {
            $dataFile[] = [
                'nim'           => $data[0],
                'nama'          => $data[1],
                'kelamin'       => $data[2],
                'tgl_lahir'     => $data[3],
                'agama'         => $data[4],
                'no_telp'       => $data[5],
                'angkatan'      => $data[6],
                'jurusan'       => $data[7],
                'validated'     => true,
                'created_at'    => $timeNow,
                'updated_at'    => $timeNow,
            ];
        }
        fclose($fileHandle);

        // Validasi batch
        // $validator = Validator::make($dataFile, [
        //     '*.nama'            => 'required|string',
        //     '*.nim'             => 'required|string|unique:alumni,nim',
        //     '*.tgl_lahir'       => 'required|date',
        //     '*.jurusan'         => 'required|string',
        //     '*.angkatan'        => 'required|string|max:4',
        //     '*.kelamin'         => 'required|string|in:l,p',
        //     '*.agama'           => 'required|string|in:Islam,Kristen Protestan,Kristen Katolik,Hindu,Buddha,Konghucu',
        //     '*.golongan_darah'  => 'nullable|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
        //     '*.no_telp'         => 'nullable|string|max:20',
        // ]);
        
        // if ($validator->fails()) {
        //     $errors = $validator->errors()->toArray();
        //     return response()->json([
        //         'success'   => false,
        //         'message'   => 'Beberapa data tidak valid',
        //         'data'    => $dataFile,
        //         'errors'    => $errors,
        //     ], 400);
        // }
        
        // Alumni::insert($dataFile);
        $batchSize = 1000; // Atur sesuai kebutuhan
        $batches = array_chunk($dataFile, $batchSize);
        DB::transaction(function() use ($batches) {
            foreach ($batches as $batch) {
                Alumni::insert($batch);
            }
        });

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil menambahkan data alumni',
            'data'      => $dataFile,
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
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required',
            'id_user'   => $user->is_admin ? 'required' : '', 
        ]);
        
        if ( $validator->fails() ) {
            return response()->json(
            [
                'success' => false,
                'message' => implode('\n',$validator->errors()->all()),
            ], 400);
        }
        
        if ( Alumni::where('id_user', $user->id_user)->first() ) {
            return response()->json(
            [
                'success' => false,
                'message' => 'User sudah memiliki data alumni',
            ], 400);
        }

        $alumni = Alumni::find($request->id_alumni);
        if( !$alumni ) {
            return response()->json(
            [
                'success' => false,
                'message' => 'Data alumni tidak ditemukan',
            ], 400);
        }
        
        if ( $alumni->id_user != null && !$user->is_admin ) {
            return response()->json(
            [
                'success' => false,
                'message' => 'Data alumni sudah diklaim pengguna lain',
            ], 401);
        }

        $alumni->update([
            'id_user'       => $user->is_admin ? $request->id_user : $user->id_user,
            'no_anggota'    => AlumniHelper::generateNoAnggota($alumni->jurusan, $alumni->angkatan),
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data alumni berhasil diklaim.',
            'data'      => $alumni,
        ], 200);
    }

    public function validateDataAlumni(Request $request) {
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
