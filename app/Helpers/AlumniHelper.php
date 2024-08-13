<?php

namespace App\Helpers;

use App\Models\Alumni;
use App\Models\Jurusan;

class AlumniHelper {
    public static function generateNoAnggota($jurusan, $angkatan)
    {
        $alumni = Alumni::select('angkatan', 'jurusan', Alumni::raw('count(*) as total'))
                        ->where('jurusan', $jurusan)
                        ->where('angkatan', $angkatan)
                        ->where('validated', true)
                        ->whereNotNull('id_user')
                        ->lockForUpdate()
                        ->groupBy('angkatan', 'jurusan')
                        ->first();
        
        $kode_jurusan = Jurusan::where('nama_jurusan', $jurusan)->first()->kode_jurusan;
        $kode_angkatan = substr($angkatan, -2);
        $kode_anggota = str_pad($alumni ? $alumni->count+1 : 1, 3, '0', STR_PAD_LEFT);

        return $kode_jurusan . $kode_angkatan . $kode_anggota;
    }

    public static function getNomorTelepon($text) {
        // Pola regex untuk mengambil nomor telepon
        $pattern = '/\b\d{10,15}\b/';

        // Mencari nomor telepon dalam string
        if (preg_match($pattern, $text, $matches)) {
            $phoneNumber = $matches[0];
            return $phoneNumber; // Output: 081319337809
        } else {
            return "Nomor telepon tidak ditemukan.";
        }
    }

    public static function getStrata($nim) {
        $strata = [
            '1' => 'S1',
            '2' => 'S2',
            '3' => 'S3'
        ];

        $str = substr($nim, 3, 1);
        if($str < 4) {
            return $strata[$str]; 
        }
        $profesi = substr($nim, 0, 3);
        // return $profesi === 'D06' ? 'Program Profesi Arsitektur' : 'Program Profesi Insinyur';
        return $profesi === 'D06' ? 'PPA' : 'PPI';
    }
}