<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_alumni' => $this->id_alumni,
            'id_user'   => $this->id_user,
            'nama'      => $this->nama,
            'no_anggota' => $this->no_anggota,
            'tgl_lahir' => $this->tgl_lahir,
            'no_telp'   => $this->no_telp,
            'kelamin'   => $this->kelamin,
            'golongan_darah' => $this->golongan_darah,
            'agama'     => $this->agama,
            'jenjang'   => $this->jenjang_pendidikan->first()->jenjang ?? '',
            'angkatan'  => $this->jenjang_pendidikan->first()->angkatan ?? '',
            'jurusan'   => $this->jenjang_pendidikan->first()->jurusan ?? '',
            'nim'       => $this->jenjang_pendidikan->first()->nim ?? '',
        ];
    }
}
