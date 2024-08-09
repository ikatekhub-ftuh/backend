<?php

namespace App\Http\Controllers;

use App\Models\Loker;
use App\Models\Perusahaan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokerController extends Controller
{
    public function get(Request $request)
    {
        $query = Loker::query();

        if ($request->has('id_loker')) {
            $query->where('id_loker', $request->id_loker);
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

        $limit = $request->has('limit') ? $request->limit : 10;
        $request->has('page') ? $query->offset($limit * ($request->page - 1)) : null;
        $result = $query->paginate($limit);

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
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
            'judul' => 'required',
            'konten' => 'required',
            'lokasi' => 'required',
            'id_perusahaan' => 'required',
            'tgl_selesai' => 'required',
            'role' => 'required',
            'pengalaman_kerja' => 'required',
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
            'message' => 'end of function',
            'request' => $request->all(),
            'data' => $loker,
        ]);
    }

    public function get_perusahaan(Request $request)
    {
        $query = Perusahaan::query();
        
        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
            $result = $query->get();
            
            return response()->json([
                'message' => 'success',
                'request' => $request->all(),
                'data' => $result
            ], 200);
        }
        
        $result = $query->get();
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ]);
    }
    
    public function post_perusahaan(Request $request){
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

        $gambarUrl = $request->file('logo')->store('logo/perusahaan', 'public');

        $validatedData['logo'] = $gambarUrl;

        $perusahaan = Perusahaan::create($validatedData);

        return response()->json([
            'message' => 'end of function',
            'request' => $request->all(),
            'data' => $perusahaan,
        ]);
    }


}
