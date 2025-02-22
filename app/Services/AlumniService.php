<?php

namespace App\Services;

use App\Helpers\AlumniHelper;
use App\Models\Alumni;
use Illuminate\Support\Facades\Auth;

class AlumniService
{
    public function storeAlumni($data)
    {
        $user = Auth::user();

        $data['validated'] = false;

        // Jika user menambahkan sendiri datanya dan sudah memiliki data alumni
        if (!$user->is_admin && $user->alumni !== null) {
            throw new \Exception('User sudah memiliki data alumni', 400);
        }

        // Jika admin, data langsung tervalidasi
        if ($user->is_admin) {
            $data['validated'] = true;
        }

        // jika bukan admin, maka langsung buatkan nomor anggota
        if (!$user->is_admin) {
            $data['id_user'] = $user->id_user;
            $data['no_anggota'] = AlumniHelper::generateNoAnggota($data['jurusan'], $data['angkatan'], $data['kelamin']);
        }

        $alumni = Alumni::create($data);

        $alumni->jenjang_pendidikan()->create([
            'id_alumni' => $alumni->id_alumni,
            'jenjang' => $data['jenjang'],
            'jurusan' => $data['jurusan'],
            'angkatan' => $data['angkatan'],
            'nim' => $data['nim'],
        ]);

        return $alumni;
    }
}
