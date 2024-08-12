<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function get()
    {
        $query = Event::query();
        $result = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $result
        ], 200);
    }

    public function getbyId($id)
    {
        $query = Event::query();
        $query->find($id);
        $result = $query->first();

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'event tidak ditemukan',
            ], 404);
        }

        // return wheter user is registered to the event
        $result->is_registered = $result->peserta_event()->where('id_user', request()->user()->id_user)->exists();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $result
        ], 200);
    }

    public function delete(Request $request)
    {
        $event = Event::find($request->id_event);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'success',
            'request' => $request->all(),
            'data' => $event
        ], 200);
    }

    public function post(Request $request)
    {
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
                'success' => false,
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
            'success' => true,
            'message' => 'message',
            'data' => $event,
        ]);
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_event' => 'required|exists:events,id_event',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $peserta_event = Event::find($request->id_event)->peserta_event()->where('id_user', $request->user()->id_user)->first();

        if ($peserta_event) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar pada event ini',
            ], 422);
        }

        $event = Event::query();
        $event->find($request->id_event);
        $event = $event->first();

        if ($event->kuota <= $event->peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota sudah terpenuhi',
            ], 422);
        }

        $event->peserta += 1;
        $event->save();

        $event->peserta_event()->create([
            'id_event' => $request->id_event,
            'id_user' => $request->user()->id_user,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'message',
            'data' => $event,
        ]);
    }

    public function unregister(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_event' => 'required|exists:events,id_event',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $peserta_event = Event::find($request->id_event)->peserta_event()->where('id_user', $request->user()->id_user)->first();

        if (!$peserta_event) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum terdaftar pada event ini',
            ], 422);
        }

        $event = Event::find($request->id_event);
        $event->peserta -= 1;
        $event->save();
        $peserta_event->delete();

        return response()->json([
            'success' => true,
            'message' => 'message',
            'data' => $event,
        ]);
    }
}
