<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getAllDataEvent()
    {
        $data = Event::all();

        return response()->json($data, 200);
    }

    public function getAllDataEventById($id)
    {
        $data = Event::find($id);

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
