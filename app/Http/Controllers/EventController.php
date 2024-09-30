<?php

namespace App\Http\Controllers;

use App\Helpers\ImageCompress;
use App\Models\Berita;
use App\Models\Event;
use App\Models\peserta_event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function get(Request $request)
    {
        $query = Event::query();
        $result = $query->get();

        $limit = $request->input('limit', 10);

        if ($request->has('all') && $request->user()->is_admin) {
            $result = $query->paginate(Berita::count());
        } else {
            $result = $query->paginate($limit);
        }

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
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $result->is_registered = $result->peserta_event()->where('id_user', request()->user()->id_user)->exists();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $result
        ], 200);
    }

    public function delete(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_event' => 'required',
            'id_event.*' => 'required|exists:events,id_event|integer',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        // $event = Event::find($request->id_event);
        $event = Event::whereIn('id_event', $request->id_event)->get();

        // event each delete but also delete the image
        foreach ($event as $e) {
            Storage::disk('public')->delete($e->gambar);
            $e->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
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
            'deskripsi'     => 'required',
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

        $imageFile  = $request->file('gambar');

        $tempPath   = $imageFile->getPathname();
        ImageCompress::compressImage($tempPath, 75);

        $gambarUrl = $imageFile->store('gambar/event', 'public');
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

    public function toggleRegister(Request $request)
    {
        $event = Event::find($request->id_event);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => 'Event not found'
            ], 404);
        }

        $user = $request->user();
        $peserta = $event->peserta_event()->where('id_user', $user->id_user)->first();

        if ($peserta) {
            // Unregister
            DB::table('peserta_event')
                ->where('id_user', $user->id_user)
                ->where('id_event', $event->id_event)
                ->delete();
            $event->peserta--;
            $isRegistered = false;
        } else {
            // Check kuota
            if ($event->kuota <= $event->peserta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota sudah terpenuhi',
                ], 422);
            }

            // Register
            DB::table('peserta_event')->insert([
                'id_user' => $user->id_user,
                'id_event' => $event->id_event,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $event->peserta++;
            $isRegistered = true;
        }

        $event->save();

        $event->is_registered = $isRegistered;

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $event,
        ], 200);
    }

    public function update(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_event'      => 'required|exists:events,id_event',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $event = Event::find($request->id_event);


        $updateData = array_filter($request->only(
            'judul',
            'gambar',
            'penyelenggara',
            'konten',
            'deskripsi',
            'tgl_event',
            'lokasi_event',
            'kuota'
        ));

        if ($request->hasFile('gambar')) {

            // delete old image
            Storage::disk('public')->delete($event->gambar);

            $imageFile  = $request->file('gambar');
            $tempPath   = $imageFile->getPathname();
            ImageCompress::compressImage($tempPath, 75);
            $gambarUrl = $imageFile->store('gambar/event', 'public');
            $updateData['gambar'] = $gambarUrl;
        }


        $event->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $event,
        ], 200);
    }

    public function pesertaEvent(Request $request)
    {
        $request->validate([
            'id_event' => 'required|integer',
        ]);

        $event = Event::with('peserta_event.user')->find($request->id_event);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event tidak ditemukan',
            ], 404);
        }

        $peserta = $event->peserta_event->map(function ($pesertaEvent) {
            return [
                'id_user' => $pesertaEvent->user->id_user,
                'nama' => $pesertaEvent->user->alumni->nama ?? 'peserta',
                'waktu_daftar' => $pesertaEvent->created_at->format('Y-m-d H:i:s')
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $peserta
        ], 200);
    }

    // Get Public
    public function getBySlug($slug)
    {
        $event = Event::with('peserta_event')->where('slug', $slug)->first();

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $event
        ], 200);
    }
}
