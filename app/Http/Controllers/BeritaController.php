<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function get(Request $request)
    {
        $query = Berita::query();

        $request->has('id') ? $query->where('id_berita', $request->id) : null;
        $request->has('offset') ? $query->skip($request->offset) : null;
        $request->has('limit') ? $query->take($request->limit) : null;
        $request->has('category') ? $query->where('id_kategori_berita', $request->category) : null;
        
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
        
        $v = $request->validate([
            'category' => 'required',
            'title' => 'required',
            'thumbnail' => 'required',
            'content' => 'required',
        ]);

        $slug = strtolower(str_replace(' ', '-', $v['title']));

        return response()->json([
            'message' => 'end of function',
            'data' => $v,
            'slug' => $slug
        ]);
    }
}
