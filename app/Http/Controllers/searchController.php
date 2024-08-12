<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Loker;
use Illuminate\Http\Request;

class searchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;

        if (!$search) {
            return response()->json([
                'success' => false,
                'message' => 'search query not found',
                'data' => null
            ], 400);
        }

        if (strlen($search) < 3) {
            return response()->json([
                'success' => false,
                'message' => 'search query too short',
                'data' => null
            ], 400);
        }

        $query = Berita::query();
        $query->where('judul', 'ilike', '%' . $search . '%');
        $countBerita = $query->count();

        $query = Loker::query();
        $query->where('judul', 'ilike', "%{$search}%")
            // it works, don't touch it
            ->orWhereRelation('perusahaan', 'nama_perusahaan', 'ilike', "%{$search}%");
        $countLoker = $query->count();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => [
                'berita' => $countBerita,
                'loker' => $countLoker
            ]
        ], 200);
    }
}
