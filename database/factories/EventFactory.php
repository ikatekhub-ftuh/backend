<?php
    namespace Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Str;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
     */
    class EventFactory extends Factory
    {
        /**
         * Index untuk menentukan posisi data event saat ini dalam array.
         */
        protected static $eventIndex = 0;

        /**
         * Data event yang akan digunakan untuk menghasilkan data event palsu.
         */
        protected static $eventData = [
            [
                'judul'         => 'Launching ANTEK HUB',
                'slug'          => 'launching-antek-hub',
                'gambar'        => 'gambar/event/launching-antek-hub.png',
                'konten'        => 'Pada tanggal 31 Agustus 2024, Fakultas Teknik Universitas Hasanuddin akan menggelar acara spesial dalam rangka Dies Natalis yang ke-64. Salah satu highlight dari perayaan ini adalah launching aplikasi "ANTEK HUB," sebuah platform inovatif yang dirancang untuk memfasilitasi komunikasi dan kolaborasi antara mahasiswa, dosen, dan alumni Fakultas Teknik UNHAS.',
                'deskripsi'     => 'Pada tanggal 31 Agustus 2024, Dies Natalis yang ke-64.',
                'penyelenggara' => 'Fakultas Teknik UNHAS',
                'tgl_event'     => '2024-08-31',
                'lokasi_event'  => 'Makassar',
                'kuota'         => 5000,
                'peserta'       => 0,
                'created_at'    => '2024-08-21 12:21:37',
                'updated_at'    => '2024-08-21 12:21:37'
            ],
            [
                'judul'         => 'Kompetisi Inovasi Teknologi Mahasiswa Teknik UNHAS 2024',
                'slug'          => 'kompetisi-inovasi-teknologi-mahasiswa-teknik-unhas-2024',
                'gambar'        => 'gambar/event/kompetisi-inovasi-teknologi.png',
                'konten'        => 'Fakultas Teknik Universitas Hasanuddin akan menggelar "Kompetisi Inovasi Teknologi Mahasiswa 2024" pada bulan November mendatang. Kompetisi ini merupakan ajang bagi mahasiswa untuk menampilkan inovasi teknologi yang telah mereka kembangkan selama kuliah.',
                'deskripsi'     => 'Kompetisi Inovasi Teknologi Mahasiswa 2024',
                'penyelenggara' => 'Fakultas Teknik UNHAS',
                'tgl_event'     => '2024-10-30',
                'lokasi_event'  => 'Gowa',
                'kuota'         => 5000,
                'peserta'       => 0,
                'created_at'    => '2024-08-21 12:21:37',
                'updated_at'    => '2024-08-21 12:21:37'
            ],
            [
                'judul'         => 'Kuliah Umum Teknik Sipil dengan Pembicara Nasional',
                'slug'          => 'kuliah-umum-teknik-sipil-dengan-pembicara-nasional',
                'gambar'        => 'gambar/event/kuliah-umum-teknik-sipil.png',
                'konten'        => 'Fakultas Teknik Universitas Hasanuddin akan mengadakan kuliah umum dengan tema "Inovasi dan Tantangan dalam Proyek Infrastruktur di Indonesia" pada tanggal 10 September 2024. Kuliah umum ini akan menghadirkan pembicara nasional yang merupakan ahli dalam bidang teknik sipil dan infrastruktur.',
                'deskripsi'     => 'Inovasi dan Tantangan dalam Proyek Infrastruktur di Indonesia pada tanggal 10 September 2024.',
                'penyelenggara' => 'Fakultas Teknik UNHAS',
                'tgl_event'     => '2024-11-08',
                'lokasi_event'  => 'Gowa',
                'kuota'         => 5000,
                'peserta'       => 0,
                'created_at'    => '2024-08-21 12:21:37',
                'updated_at'    => '2024-08-21 12:21:37'
            ],
        ];

        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            // Dapatkan data dari array berdasarkan index
            $data = self::$eventData[self::$eventIndex];

            // Tingkatkan index untuk data berikutnya
            self::$eventIndex++;

            // Jika index mencapai batas array, reset kembali ke 0 (opsional, jika ingin looping)
            if (self::$eventIndex >= count(self::$eventData)) {
                self::$eventIndex = 0;
            }

            return [
                // 'id_event' => $data['id_event'],
                'judul'         => $data['judul'],
                'slug'          => $data['slug'],
                'gambar'        => $data['gambar'],
                'konten'        => $data['konten'],
                'deskripsi'     => $data['deskripsi'],
                'penyelenggara' => $data['penyelenggara'],
                'tgl_event'     => $data['tgl_event'], // Kosong jika tidak diisi
                'lokasi_event'  => $data['lokasi_event'], // Kosong jika tidak diisi
                'kuota'         => $data['kuota'],
                'peserta'       => $data['peserta'],
                'created_at'    => $data['created_at'], // Kosong jika tidak diisi
                'updated_at'    => $data['updated_at'], // Kosong jika tidak diisi
            ];
        }
    }
