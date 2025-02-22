<?php

namespace App\Services;

use App\Helpers\AlumniHelper;
use App\Models\Alumni;
use Illuminate\Support\Facades\Auth;

class ClaimAlumniService
{
    public function getAlumniData($request)
    {
        return Alumni::where('nama', $request->nama)
            ->where('tgl_lahir', $request->tgl_lahir)
            ->whereHas('jenjang_pendidikan', function ($query) use ($request) {
                $query->where('jurusan', $request->jurusan);
            })
            ->get();
    }

    public function claimAlumni(array $data)
    {
        $user = Auth::user();

        $alumni = Alumni::find($data['id_alumni']);
        if (!$alumni) {
            throw new \Exception('Data Alumni tidak ditemukan', 404);
        }

        // Jika user yang mengklaim data yang sudah di klaim
        if (!$user->is_admin && $alumni->id_user !== null) {
            throw new \Exception('Data Alumni sudah di-claim', 400);
        }

        $jenjang_pendidikan = $alumni->jenjang_pendidikan->first();

        if (!$jenjang_pendidikan) {
            throw new \Exception('Data Jenjang Pendidikan tidak ditemukan', 404);
        }

        $newNoAnggota = AlumniHelper::generateNoAnggota(
            $jenjang_pendidikan->jurusan,
            $jenjang_pendidikan->angkatan,
            $alumni->kelamin
        );

        $alumni->update([
            'id_user' => $user->id_user,
            'no_anggota' => $alumni->no_anggota ?? $newNoAnggota,
        ]);

        return $alumni;
    }
}
