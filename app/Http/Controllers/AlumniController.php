<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumniUpdateRequest;
use App\Http\Requests\ClaimAlumniRequest;
use App\Http\Requests\StoreAlumniRequest;
use App\Http\Resources\AlumniResource;
use App\Models\Alumni;
use App\Models\Jurusan;
use App\Models\User;
use App\Services\AlumniService;
use App\Services\ClaimAlumniService;
use App\Services\UploadDataAlumniService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    public function __construct(private AlumniService $alumniService) {}

    public function get(Request $request)
    {
        // for admin
        if ($request->has('admin') && $request->admin === 'true' && Auth::user()->is_admin) {
            $query = Alumni::leftJoin('jenjang_pendidikan', 'alumni.id_alumni', 'jenjang_pendidikan.id_alumni');
            $query->where('validated', true);

            if ($request->has('search')) {
                $query->where('nama', 'ilike', '%' . $request->search . '%')
                    ->orWhere('tgl_lahir', 'ilike', '%' . $request->search . '%')
                    ->orWhere('no_telp', 'ilike', '%' . $request->search . '%')
                    ->orWhere('nim', 'ilike', '%' . $request->search . '%');
            }

            $result = $query->paginate($request->limit ?? 10);


            return response()->json([
                'message' => 'success',
                'data' => $result
            ], 200);
        }

        // unchanged- tapi ketemu ka error: attempt to read jenjang pendidikan on null
        $query = Alumni::join('jenjang_pendidikan', 'alumni.id_alumni', 'jenjang_pendidikan.id_alumni');
        $query->where('validated', true);

        return $query->get();

        // Jika parameter id_alumni ada maka kembalikan data detail alumni
        if ($request->has('id_alumni')) {
            // $query->select('id_alumni', 'id_user', 'nim', 'no_anggota', 'nama', 'no_telp', 'jurusan', 'angkatan', 'kelamin', 'agama', 'golongan_darah', )
            $query->select('alumni.id_alumni as id_alumni', 'id_user', 'no_anggota', 'nama', 'no_telp', 'kelamin', 'agama', 'golongan_darah',)
                ->where('alumni.id_alumni', $request->id_alumni);
            $alumni = $query->first();

            if (!$alumni) {
                return response()->json([
                    'message'   => 'error',
                    'errors'    => 'Data not found'
                ], 404);
            }

            $alumni->load('user', 'jenjang_pendidikan');

            return response()->json([
                'message'   => 'success',
                'request'   => $request->all(),
                'data'      => $alumni
            ], 200);
        }

        // Jika parameter angkatan ada dan jurusan ada, kembalikan list data alumni
        if ($request->has('angkatan') && $request->has('jurusan')) {
            if ($request->angkatan !== 'all') {
                $query->where('jenjang_pendidikan.angkatan', $request->angkatan);
            }
            $query->where('jenjang_pendidikan.jurusan',    $request->jurusan);

            if ($request->has('search')) {
                $query->where('nama', 'ilike', '%' . $request->search . '%');
            }

            $query->orderBy('nama', 'asc');
            $query->orderBy('no_anggota', 'asc');
            $result = $query->get();
            return response()->json([
                'message'   => 'success',
                'request'   => $request->all(),
                'data'      => $result
            ], 200);
        }

        // Jika parameter angkatan ada, kembalikan list jurusan dan data total alumninya
        if ($request->has('angkatan') && !$request->has('all')) {
            if ($request->angkatan !== 'all') {
                $query->where('jenjang_pendidikan.angkatan', $request->angkatan);
            }

            $query->select('jenjang_pendidikan.jurusan')
                ->selectRaw('count(*) as total')
                ->groupBy('jenjang_pendidikan.jurusan');

            if ($request->has('search')) {
                $query->where('nama', 'ilike', '%' . $request->search . '%');
            }

            $query->orderBy('jenjang_pendidikan.jurusan', 'asc');
            $result = $query->get();
            return response()->json([
                'message'   => 'success',
                'request'   => $request->all(),
                'data'      => $result
            ], 200);
        }

        // kembalikan data angkatan dan total alumninya
        $query->select('angkatan')
            ->selectRaw('count(*) as total')
            ->groupBy('angkatan');

        // jika parameter all bernilai false, kembalikan data alumni berdasarkan angkatan
        if ($request->has('all') && $request->all === 'false') {
            if ($request->has('angkatan')) {
                $query->where('angkatan', $request->angkatan);
            } else {
                $angkatan = User::with('alumni')->find(Auth::id())->alumni->angkatan;
                $query->where('angkatan', $angkatan);
            }
        }

        // jika tidak ada parameter all, maka kembalikan data angkatan dari user
        if (!$request->has('all')) {
            $angkatan = User::find(Auth::id())->alumni->jenjang_pendidikan->first->angkatan->angkatan;
            $query->where('angkatan', $angkatan);
        }

        if ($request->has('search')) {
            $query->where('nama', 'ilike', '%' . $request->search . '%');
        }

        $query->orderBy('angkatan', 'desc');
        $result = $query->get();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function getDataToClaim(Request $request, ClaimAlumniService $claimAlumniService)
    {
        $request->validate([
            'nama'      => 'required|string',
            'tgl_lahir' => 'required|date',
            'jurusan'   => 'required|string',
        ]);

        $data = $claimAlumniService->getAlumniData($request);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => AlumniResource::collection($data)
        ], 200);
    }

    public function post(StoreAlumniRequest $request)
    {
        $data = $this->alumniService->storeAlumni($request->validated());
        return new AlumniResource($data);
    }

    public function update(Alumni $alumni, AlumniUpdateRequest $request)
    {
        $alumni->update($request->all());
        return new AlumniResource($alumni);
    }

    public function upload(Request $request, UploadDataAlumniService $uploadDataAlumniService)
    {
        $validator = Validator::make($request->all(), [
            'file_alumni' => 'required|file|mimes:csv,txt',
        ]);

        $uploadDataAlumniService->uploadDataAlumni($validator->validated());

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil menambahkan data alumni dan jenjang',
        ], 201);
    }


    public function delete(Alumni $alumni)
    {
        $alumni->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data alumni.'
        ], 200);
    }

    public function claimDataALumni(ClaimAlumniRequest $request, ClaimAlumniService $claimAlumniService)
    {
        $data = $claimAlumniService->claimAlumni($request->validated());
        return new AlumniResource($data);
    }

    public function validateData(Alumni $alumni)
    {
        $alumni = $alumni->update([
            'validated' => true,
        ]);

        return response()->json(['message' => 'Data alumni berhasil divalidasi']);
    }

    public function getJurusan()
    {
        $query = Jurusan::query();
        $result = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $result
        ], 200);
    }
}
