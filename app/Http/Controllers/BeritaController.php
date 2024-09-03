<?php

namespace App\Http\Controllers;

use App\Helpers\ImageCompress as HelpersImageCompress;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{

    // public function get(Request $request)
    // {
    //     $query = Berita::with('likes');
    //     // ilike = case insensitive (only for postgres)
    //     $request->has('search') ? $query->where('judul', 'ilike', '%' . $request->search . '%') : null;
    //     $request->has('id_kategori_berita') ? $query->where('id_kategori_berita', $request->id_kategori_berita) : null;
    //     $limit = $request->has('limit') ? $request->limit : 10;
    //     $result = $query->paginate($limit);
    //     return response()->json([
    //         'message' => 'success',
    //         'data' => $result
    //     ], 200);
    // }

    public function get(Request $request)
    {
        $userId = $request->user()->id_user;

        $query = Berita::with('kategori')
            ->select('berita.id_berita', 'judul', 'penulis', 'gambar', 'berita.slug', 'total_like', 'konten', 'deskripsi', 'berita.id_kategori_berita', 'berita.created_at', 'berita.updated_at')
            // Menambahkan join untuk mendapatkan status is_liked
            ->leftJoin('likes', function ($join) use ($userId) {
                $join->on('berita.id_berita', '=', 'likes.id_berita')
                    ->where('likes.id_user', '=', $userId);
            })
            ->addSelect(DB::raw('CASE WHEN likes.id_berita IS NOT NULL THEN true ELSE false END AS is_liked'));

        if ($request->has('search')) {
            $query->where('judul', 'ilike', '%' . $request->search . '%');
        }

        if ($request->has('id_kategori_berita')) {
            $query->where('berita.id_kategori_berita', $request->id_kategori_berita);
        }

        // Menambahkan pengurutan hanya berdasarkan created_at
        $query->orderBy('berita.created_at', 'desc'); // Urutkan berdasarkan tanggal terbaru
        $query->orderBy('berita.total_like', 'desc'); // Urutkan berdasarkan tanggal terbaru

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

    public function getById(Request $request, $id)
    {
        $berita = Berita::with("kategori")->find($id);
        $berita->is_liked = $berita->likes()->where('id_user', $request->user()->id_user)->exists();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $berita
        ], 200);
    }

    public function delete(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_berita' => 'required|array',
            'id_berita.*' => 'required|integer'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $berita = Berita::whereIn('id_berita', $request->id_berita)->get();

        if ($berita->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $berita->each->delete();

        return response()->json([
            'success' => true,
            'message' => 'success',
        ], 200);
    }


    public function post(Request $request)
    {

        $v = Validator::make($request->all(), [
            'id_kategori_berita'    => 'required',
            'judul'                 => 'required',
            'gambar'                => 'required',
            'konten'                => 'required',
            'deskripsi'             => 'required',
            'penulis'               => 'required',
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
        HelpersImageCompress::compressImage($tempPath, 75);

        $gambarUrl = $imageFile->store('gambar/berita', 'public');
        $validatedData['gambar'] = $gambarUrl;

        $slug = strtolower(Str::slug($request->judul));
        $validatedData['slug'] = $slug;

        $berita = Berita::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $berita,
        ], 200);
    }

    public function update(Request $request)
    {
        if ($request->hasFile('gambar')) {
            $imageFile  = $request->file('gambar');
            $tempPath   = $imageFile->getPathname();
            HelpersImageCompress::compressImage($tempPath, 75);
            $gambarUrl = $imageFile->store('gambar/berita', 'public');
        }

        $berita = Berita::find($request->id_berita);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $updateData = array_filter($request->only([
            'id_kategori_berita',
            'judul',
            'konten',
            'deskripsi',
            'penulis',
        ]), function ($value) {
            return !is_null($value);
        });

        $berita->update($updateData);

        if ($request->hasFile('gambar')) {
            $berita->gambar = $gambarUrl;
            $berita->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $berita
        ], 200);
    }

    public function category_get(Request $request)
    {
        $query = KategoriBerita::query();
        $request->id_kategori_berita ? $query->where('id_kategori_berita', $request->id_kategori_berita) : null;
        $result = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $result
        ], 200);
    }

    public function category_post(Request $request)
    {
        $v = $request->validate([
            'kategori' => 'required',
        ]);

        $v['slug'] = strtolower(Str::slug($v['kategori']));
        $kategori = KategoriBerita::create($v);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $kategori,
        ], 200);
    }

    public function category_delete(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_kategori_berita' => 'required',
        ]);

        $kategori = KategoriBerita::where('id_kategori_berita', $request->id_kategori_berita)->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'error',
            ], 404);
        }

        $kategori->delete();
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $kategori
        ], 200);
    }

    public function togglelike(Request $request)
    {
        $berita = Berita::find($request->id_berita);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $user = $request->user();
        $like = $berita->likes()->where('id_user', $user->id_user)->first();

        if ($like) {
            // Unlike
            DB::table('likes')
                ->where('id_user', $user->id_user)
                ->where('id_berita', $berita->id_berita)
                ->delete();
            $berita->total_like--;
            $isLiked = false;
        } else {
            // Like
            // $berita->likes()->create(['id_user' => $user->id_user]);
            $berita->likes()->insert([
                'id_user' => $user->id_user,
                'id_berita' => $berita->id_berita,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $berita->total_like++;
            $isLiked = true;
        }

        $berita->save();

        $berita->is_liked = $isLiked;

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $berita
        ], 200);
    }


    public function listLikes(Request $request)
    {
        // Validasi input untuk memastikan id_berita ada dan merupakan integer
        $request->validate([
            'id_berita' => 'required|integer',
        ]);

        // Cari berita berdasarkan id_berita
        $berita = Berita::with('likes.user')->find($request->id_berita);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        // Mendapatkan semua user yang memberi like dengan data user
        $likes = $berita->likes->map(function ($like) {
            return [
                'id_user' => $like->user->id_user,
                'nama' => $like->user->alumni->nama ?? 'anonymous', // Menggunakan relasi ke tabel alumni untuk mengambil nama user
                'waktu_like' => $like->created_at->format('Y-m-d H:i:s')
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $likes
        ], 200);
    }
}
