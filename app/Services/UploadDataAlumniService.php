<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\JenjangPendidikan;
use Illuminate\Support\Facades\DB;

class UploadDataAlumniService
{
    public function uploadDataAlumni($data)
    {
        $file = $data->file('file_alumni');
        $fileHandle = fopen($file->getPathname(), 'r');
        $timeNow = \Carbon\Carbon::now();

        // Skip header row
        fgetcsv($fileHandle, 0, ";");

        $jenjangData = [];

        DB::transaction(function () use ($fileHandle, $timeNow, &$jenjangData) {
            while (($data = fgetcsv($fileHandle, 0, ";")) !== false) {
                // Insert alumni data and get the id
                $idAlumni = Alumni::insertGetId([
                    'nama'          => $data[1],
                    'kelamin'       => $data[2],
                    'tgl_lahir'     => $data[3],
                    'agama'         => $data[4],
                    'no_telp'       => $data[5],
                    'validated'     => true,
                    'created_at'    => $timeNow,
                    'updated_at'    => $timeNow,
                ], 'id_alumni');

                // Prepare jenjang data with the corresponding id_alumni
                $jenjangData[] = [
                    'nim'           => $data[0],
                    'angkatan'      => $data[6],
                    'jurusan'       => $data[7],
                    'jenjang'       => $data[8],
                    'id_alumni'     => $idAlumni, // Set the related alumni id
                    'created_at'    => $timeNow,
                    'updated_at'    => $timeNow,
                ];
            }

            // Batch insert jenjang pendidikan
            if (!empty($jenjangData)) {
                JenjangPendidikan::insert($jenjangData);
            }
        });

        fclose($fileHandle);
    }
}
