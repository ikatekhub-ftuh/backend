<?php

namespace App\Http\Controllers;

use App\Models\Loker;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    public function get(Request $request)
    {
        $query = Loker::query();

        // $limit = $request->has('limit') ? $request->limit : 10;

        $request->has('id') ? $query->where('id_loker', $request->id) : null;
        // $request->has('page') ? $query->offset($limit * ($request->page - 1)) : null;

        // $query->limit($limit);
        $result = $query->get();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function delete(Request $request)
    {
        $loker = Loker::where('id_loker', $request->id)->first();
        $loker->delete();
        return response()->json([
            'message' => 'Berhasil menghapus Loker.'
        ], 200);
    }
}
