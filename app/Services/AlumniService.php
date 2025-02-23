<?php

namespace App\Services;

use App\Helpers\AlumniHelper;
use App\Http\Resources\AlumniResource;
use App\Http\Resources\AngkatanAlumniResource;
use App\Http\Resources\JurusanAlumniResource;
use App\Models\Alumni;
use App\Models\JenjangPendidikan;
use Illuminate\Support\Facades\Auth;

class AlumniService
{
    public function getAlumni($request)
    {
        if ($request->has('all') && $request->all == "true") {
            return $this->getAngkatan($request);
        }

        if ($request->has('all') && $request->all == "false") {
            return $this->getAngkatan($request);
        }

        if ($request->has('angkatan') && $request->has('jurusan')) {
            return $this->getDataAlumni($request);
        }

        if ($request->has('angkatan')) {
            return $this->getJurusan($request);
        }

        return $this->getAngkatan($request);
    }

    public function getDataAlumni($request)
    {
        $query = Alumni::query()
            ->whereHas('jenjang_pendidikan', function ($query) use ($request) {
                $query->whereRaw('LOWER(angkatan) = ?', [strtolower($request->angkatan)])
                    ->whereRaw('LOWER(jurusan) = ?', [strtolower($request->jurusan)]);
            });

        if ($request->has('search')) {
            $query->whereRaw('LOWER(nama) like ?', ['%' . strtolower($request->search) . '%']);
        }

        $data = $query->get();

        return AlumniResource::collection($data);
    }

    public function getAngkatan($request)
    {
        $query = JenjangPendidikan::query();

        $query->select('angkatan')
            ->selectRaw('count(*) as total')
            ->groupBy('angkatan')
            ->orderBy('angkatan', 'desc');

        if ($request->has('all') && $request->all == "true") {
            $data = $query->get();
        } else if ($request->has('angkatan')) {
            $data = $query->whereRaw('LOWER(angkatan) = ?', [strtolower($request->angkatan)])->get();
        } else {
            $data = $query->whereRaw('LOWER(angkatan) = ?', [strtolower(Auth::user()->alumni->jenjang_pendidikan->first()->angkatan)])->get();
        }

        return AngkatanAlumniResource::collection($data);
    }

    public function getJurusan($request)
    {
        $query = JenjangPendidikan::query();
        $query->select('jenjang_pendidikan.jurusan')
            ->selectRaw('count(*) as total')
            ->join('alumni', 'jenjang_pendidikan.id_alumni', '=', 'alumni.id_alumni')
            ->groupBy('jenjang_pendidikan.jurusan')
            ->orderBy('jenjang_pendidikan.jurusan', 'asc');

        if ($request->has('angkatan')) {
            $query->whereRaw('LOWER(jenjang_pendidikan.angkatan) = ?', [strtolower($request->angkatan)]);
        }

        if ($request->has('search')) {
            $query->whereRaw('LOWER(alumni.nama) like ?', ['%' . strtolower($request->search) . '%']);
        }

        $data = $query->get();

        return JurusanAlumniResource::collection($data);
    }

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
