<?php

namespace App\Http\Controllers;

use App\Helpers\ImageCompress;
use App\Models\Loker;
use App\Models\Perusahaan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokerController extends Controller
{
    public function get(Request $request)
    {
        $query = Loker::with('perusahaan');

        if ($request->has('search')) {
            // search both judul and perusahaan (nama_perusahaan)
            $search = $request->search;
            $query->where('judul', 'ilike', "%{$search}%")
                // it works, don't touch it
                ->orWhereRelation('perusahaan', 'nama_perusahaan', 'ilike', "%{$search}%");
        }

        $limit = $request->has('limit') ? $request->limit : 10;
        $result = $query->paginate($limit);

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function getById($id)
    {
        $loker = Loker::with('perusahaan')->find($id);

        if (!$loker) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $loker
        ], 200);
    }

    public function delete(Request $request)
    {
        $loker = Loker::where('id_loker', $request->id_loker)->first();

        if (!$loker) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $loker->delete();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $loker
        ], 200);
    }

    public function post(Request $request)
    {
        $v = Validator::make($request->all(), [
            'judul'             => 'required',
            'konten'            => 'required',
            'deskripsi'         => 'required',
            'lokasi'            => 'required',
            'id_perusahaan'     => 'required',
            'tgl_selesai'       => 'required',
            'role'              => 'required',
            'pengalaman_kerja'  => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $validatedData = $v->validated();

        $slug = strtolower(Str::slug($request->judul));
        $validatedData['slug'] = $slug;

        $loker = Loker::create($validatedData);

        return response()->json([
            'message' => 'message',
            'request' => $request->all(),
            'data' => $loker,
        ]);
    }

    public function get_perusahaan(Request $request)
    {
        $query = Perusahaan::query();

        $result = $query->get();
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ]);
    }

    public function post_perusahaan(Request $request)
    {
        // gambar, nama
        $v = Validator::make($request->all(), [
            'nama_perusahaan' => 'required',
            'logo' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $validatedData = $v->validated();

        $imageFile  = $request->file('logo');
        
        $tempPath   = $imageFile->getPathname();
        ImageCompress::compressImage($tempPath, 75);

        $gambarUrl = $imageFile->store('logo/perusahaan', 'public');

        $validatedData['logo'] = $gambarUrl;

        $perusahaan = Perusahaan::create($validatedData);

        return response()->json([
            'message' => 'message',
            'request' => $request->all(),
            'data' => $perusahaan,
        ]);
    }

    public function delete_perusahaan(Request $request)
    {
        $perusahaan = Perusahaan::where('id_perusahaan', $request->id_perusahaan)->first();

        if (!$perusahaan) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $perusahaan->delete();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $perusahaan
        ], 200);
    }

    // Get Public
    public function getBySlug($slug)
    {
        $loker = Loker::with('perusahaan')->where('slug', $slug)->first();

        if (!$loker) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $loker
        ], 200);
    }
}
