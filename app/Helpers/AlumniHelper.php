<?php

namespace App\Helpers;

class AlumniHelper {
    public static function generateNoAnggota($jurusanName, $angkatan, $alumniCounts, $jurusan)
    {
        $key = $jurusanName . '-' . $angkatan;

        if (isset($alumniCounts[$key])) {
            $alumniCounts[$key]->total += 1;
        } else {
            $alumniCounts[$key] = (object)['total' => 1];
        }

        $no_anggota = $jurusan->where('nama_jurusan', $jurusanName)->first()->kode_jurusan 
                        . substr($angkatan, -2)
                        . str_pad($alumniCounts[$key]->total, 3, '0', STR_PAD_LEFT);

        return $no_anggota;
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
}