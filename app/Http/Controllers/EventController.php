<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function get(Request $request)
    {
        $query = Event::query();

        $limit = $request->has('limit') ? $request->limit : 10;

        $request->has('id') ? $query->where('id_event', $request->id) : null;
        $request->has('page') ? $query->offset($limit * ($request->page - 1)) : null;

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
        $event = Event::where('id_event', $request->id)->first();
        $event->delete();
        return response()->json([
            'message' => 'Berhasil menghapus Event.'
        ], 200);
    }

    public function post(Request $request){
        // $v = Validator::make($request->all(), [
        //     'id_kategori_berita' => 'required',
        //     'judul' => 'required',
        //     'gambar' => 'required',
        //     'konten' => 'required',
        //     'penulis' => 'required',
        // ]);
        
        // if ($v->fails()) {
        //     return response()->json([
        //         'message' => 'error',
        //         'errors' => $v->errors()
        //     ], 400);
        // }

        // $validatedData = $v->validated();

        // // store image in storage, inside public folder, in news_thumbnail folder
        // $gambarUrl = $request->file('gambar')->store('berita/thumbnail', 'public');
        // $validatedData['gambar'] = $gambarUrl;

        // $slug = strtolower(Str::slug($request->judul));
        // $validatedData['slug'] = $slug;

        // $event = Berita::create($validatedData);

        // return response()->json([
        //     'message' => 'end of function',
        //     'data' => $event,
        // ]);
    }
}
