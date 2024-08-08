<?php

namespace App\Http\Controllers;

use App\Models\Loker;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    public function getAllDataLoker()
    {
        $data = Loker::all();

        return response()->json($data, 200);
    }

    public function getAllDataLokerById($id)
    {
        $data = Loker::find($id);

        if ( is_null($data) ){
            $res = [
                'success' => false,
                'message' => "Product Not Found",
            ];
            return response()->json($res, 404);
        }
        return response()->json($data, 200);
    }
}
