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

        $limit = $request->has('limit') ? $request->limit : 10;

        $request->has('id') ? $query->where('id_berita', $request->id) : null;
        $request->has('page') ? $query->offset($limit * ($request->page - 1)) : null;
        $request->has('category') ? $query->where('id_kategori_berita', $request->category) : null;
        
        $query->limit($limit);
        $result = $query->get();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function delete(Request $request)
    {
        $berita = Berita::where('id_berita', $request->id)->first();
        $berita->delete();
        return response()->json([
            'message' => 'Berhasil menghapus Berita.'
        ], 200);
    }

    public function post(Request $request){
        
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

        $gambarUrl = $request->file('gambar')->store('berita_images', 'public');
        $validatedData['gambar'] = $gambarUrl;

        $slug = strtolower(Str::slug($request->judul));
        $validatedData['slug'] = $slug;

        $berita = Berita::create($validatedData);

        return response()->json([
            'message' => 'end of function',
            'data' => $berita,
            'request' => $request->all(),
            'result' => $validatedData
        ]);
    }

    public function category_get(Request $request){
        $query = KategoriBerita::query();
        $request->id ? $query->where('id_kategori_berita', $request->id) : null;
        $result = $query->get();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }
    
}
