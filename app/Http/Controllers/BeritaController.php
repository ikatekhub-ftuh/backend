<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    
    public function get(Request $request)
    {
        $query = Berita::query();
        
        // jika request memiliki id, maka hanya mengembalikan satu data
        if ($request->has('id_berita')) {
            $query->where('id_berita', $request->id_berita);
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

        // jika tidak memiliki id, maka mengembalikan banyak data
        $request->has('id_kategori_berita') ? $query->where('id_kategori_berita', $request->id_kategori_berita) : null;
        $limit = $request->has('limit') ? $request->limit : 10;
        $result = $query->paginate($limit);
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function delete(Request $request)
    {
        $berita = Berita::where('id_berita', $request->id_berita)->first();

        if (!$berita) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $berita->delete();
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $berita
        ], 200);
    }

    public function post(Request $request)
    {

        $v = Validator::make($request->all(), [
            'id_kategori_berita' => 'required',
            'judul' => 'required',
            'gambar' => 'required',
            'konten' => 'required',
            'penulis' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $validatedData = $v->validated();

        $gambarUrl = $request->file('gambar')->store('gambar/berita', 'public');
        $validatedData['gambar'] = $gambarUrl;

        $slug = strtolower(Str::slug($request->judul));
        $validatedData['slug'] = $slug;

        $berita = Berita::create($validatedData);

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $berita,
        ], 200);
    }

    public function category_get(Request $request)
    {
        $query = KategoriBerita::query();
        $request->id_kategori_berita ? $query->where('id_kategori_berita', $request->id_kategori_berita) : null;
        $result = $query->get();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function category_post(Request $request){
        $v = $request->validate([
            'kategori' => 'required',
        ]);

        $v['slug'] = strtolower(Str::slug($v['kategori']));
        $kategori = KategoriBerita::create($v);

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $kategori,
        ], 200);
    }

    public function category_delete(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_kategori_berita' => 'required',
        ]);
        
        $kategori = KategoriBerita::where('id_kategori_berita', $request->id_kategori_berita)->first();

        if (!$kategori) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $kategori->delete();
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $kategori
        ], 200);
    }
}
