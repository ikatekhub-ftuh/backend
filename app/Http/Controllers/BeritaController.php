<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function getAllDataBerita()
    {
        $data = Berita::all();

        return response()->json($data, 200);
    }

    public function getAllDataBeritaById($id)
    {
        $data = Berita::find($id);

        if ( is_null($data) ){
            $res = [
                'success' => false,
                'message' => "Product Not Found",
            ];
            return response()->json($res, 404);
        }
        return response()->json($data, 200);
    }

    public function deleteDataBerita($id)
    {
        $berita = Berita::find($id);

        $berita->delete();

        return response()->json([
            'message' => 'Berhasil menghapus karyawan.'
        ], 200);
    }
}
