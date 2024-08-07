<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function getAll()
    {
        $data = Berita::all();
        return response()->json([
            'beritaPertama' => $data,
        ]);
    }
}
