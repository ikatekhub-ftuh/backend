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

        $data = $this->alumniService->getAlumni($request);

        return response()->json([
            'message' => 'Berhasil mendapatkan data alumni',
            'data' => $data,
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
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengklaim data alumni',
            'data' => new AlumniResource($data)
        ], 200);
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
