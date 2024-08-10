<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function get(Request $request)
    {
        $query = Event::query();

        if ($request->has('id_event')) {
            $query->find($request->id_event);
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

        $result = $query->get();
        // ! tambahkan kuota terpenuhi

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function delete(Request $request)
    {
        $event = Event::find($request->id_event);

        if (!$event) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $event->delete();
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $event
        ], 200);
    }

    public function post(Request $request)
    {
        // return response()->json([
        //     'message' => 'message',
        //     'request' => $request->gambar,
        // ]);
        
        $v = Validator::make($request->all(), [
            'judul'         => 'required',
            'gambar'        => 'required',
            'penyelenggara' => 'required',
            'konten'        => 'required',
            'tgl_event'     => 'required',
            'lokasi_event'  => 'required',
            'kuota'         => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $validatedData = $v->validated();

        $gambarUrl = $request->file('gambar')->store('gambar/event', 'public');
        $validatedData['gambar'] = $gambarUrl;

        $slug = strtolower(Str::slug($request->judul));
        $validatedData['slug'] = $slug;

        $event = Event::create($validatedData);

        return response()->json([
            'message' => 'message',
            'request' => $request->all(),
            'data' => $event,   
        ]);
    }
}
