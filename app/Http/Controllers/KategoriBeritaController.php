<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class KategoriBeritaController extends Controller
{
    public function getAllDataKategoriBerita()
    {
        $data = KategoriBerita::all();

        return response()->json($data, 200);
    }

    public function getAllDataKategoriBeritaById($id)
    {
        $data = KategoriBerita::find($id);

        if ( is_null($data) ){
            $res = [
                'success' => false,
                'message' => "Product Not Found",
            ];
            return response()->json($res, 404);
        }
        return response()->json($data, 200);
    }

    public function delete($id)
    {
        
    }
}
