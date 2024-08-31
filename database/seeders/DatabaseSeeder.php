<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Loker;
use App\Models\Berita;
use App\Models\Perusahaan;
use App\Models\Like;
use App\Models\KategoriBerita;
use App\Models\Alumni;
use App\Models\peserta_event;
use App\Models\JenjangPendidikan;
use App\Models\Jurusan;
use App\Models\StatistikPendidikan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '1G');

        // User::factory()->create([
        //     'email' => "user@gmail.com",
        //     'password' => "12345678",
        //     'avatar' => "gambar/dummy/gambar/test.png",
        //     'is_banned' => 0,
        // ]);

        // User::factory()->create([
        //     'email' => "admin@gmail.com",
        //     'password' => "admin123",
        //     'avatar' => "gambar/dummy/gambar/test.png",
        // ]);

        // Loker::factory()->create([
        //     'id_perusahaan'     => 1,
        //     'judul'             => 'Admin Pengelola Data Alumni ANTEK HUB',
        //     'slug'              => 'admin-pengelola-data-alumni-antek-hub',
        //     'konten'            => 'Mengelola database alumni untuk memastikan informasi selalu up-to-date.<br>Memastikan validitas dan integritas data yang masuk ke dalam sistem.<br>Mengkoordinasikan kegiatan dan acara terkait alumni dengan departemen terkait.<br>Menghasilkan laporan berkala mengenai status dan statistik alumni.<br>Berkomunikasi dengan alumni melalui berbagai saluran untuk keperluan administrasi.',
        //     'tgl_selesai'       => '2024-10-01',
        //     'lokasi'            => 'Makassar',
        //     'pengalaman_kerja'  => 2,
        //     'role'              => 'Purna Waktu'
        // ]);

        // Loker::factory()->create([
        //     'id_perusahaan'     => 1,
        //     'judul'             => 'Staf Administrasi dan Pengelola Data Mahasiswa',
        //     'slug'              => 'staf-administrasi-pengelola-data-mahasiswa',
        //     'konten'            => 'Mengelola data mahasiswa termasuk pendaftaran, absensi, dan nilai.<br>Membantu dalam penyusunan jadwal kuliah dan kegiatan akademik lainnya.<br>Menyusun dan mengarsipkan dokumen administratif terkait mahasiswa.<br>Bekerjasama dengan bagian akademik untuk pengelolaan database.<br>Menyiapkan laporan data mahasiswa untuk kepentingan internal dan eksternal.',
        //     'tgl_selesai'       => '2024-09-25',
        //     'lokasi'            => 'Makassar',
        //     'pengalaman_kerja'  => 1,
        //     'role'              => 'Purna Waktu'
        // ]);

        // Loker::factory()->create([
        //     'id_perusahaan'     => 1,
        //     'judul'             => 'Admin Sistem Informasi dan Data Pegawai',
        //     'slug'              => 'admin-sistem-informasi-data-pegawai',
        //     'konten'            => 'Mengelola data pegawai dalam sistem informasi perusahaan.<br>Memonitor dan memperbarui informasi terkait kehadiran, cuti, dan performa pegawai.<br>Membantu dalam penyusunan laporan HR untuk manajemen.<br>Menyediakan dukungan administrasi terkait pengelolaan sistem informasi SDM.<br>Memastikan data pegawai tersimpan dengan aman dan rahasia.',
        //     'tgl_selesai'       => '2024-10-10',
        //     'lokasi'            => 'Makassar',
        //     'pengalaman_kerja'  => 3,
        //     'role'              => 'Purna Waktu'
        // ]);

        // Berita::factory()->create([
        //     'id_kategori_berita'    => 4, // Ganti ID sesuai kategori olahraga atau lomba
        //     'judul'                 => 'Unhas Sambut 3.046 Mahasiswa Baru Pascasarjana',
        //     'slug'                  => 'unhas-sambut-3046-mahasiswa-baru-pascasarjana',
        //     'konten'                => '
        //         <p style="text-align: left;">
        //             Universitas Hasanuddin (Unhas) menggelar prosesi penerimaan mahasiswa baru program pascasarjana bertajuk Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB) di Baruga AP Pettarani, Jumat 16 Agustus 2024.
        //         </p>
        //         <p style="text-align: left;">
        //             Pada PKKMB ini, Unhas menerima 3.046 mahasiswa baru pascasarjana yang terdiri dari program doktor, magister, profesi, spesialis, dan sub spesialis.
        //         </p>
        //         <p style="text-align: left;">
        //             Rektor Unhas Prof Dr Ir Jamaluddin Jompa MSc dalam sambutannya mengapresiasi para mahasiswa baru yang telah memilih Unhas sebagai kampus untuk melanjutkan studi. Ia menekankan bahwa mahasiswa pascasarjana, khususnya doktor adalah tumpuan harapan universitas karena mereka tulang punggung peneliti.
        //         </p>
        //         <p style="text-align: left;">
        //             “Unhas mengarahkan program S3 by riset meskipun belum semuanya siap. Bagi yang mengambil jalur riset, harus mengubah mindset bahwa saat ini Anda bukan lagi seperti S1 S2, tapi harus menjadi peneliti independen,” tegasnya.
        //         </p>
        //         <p style="text-align: left;">
        //             Pada kesempatan ini Prof JJ juga merespon kasus perundungan mahasiswa PPDS yang tengah viral. Ia menjelaskan bahwa Unhas sudah mengeluarkan aturan penyelenggaraan PPDS dan PPDGS.
        //         </p>
        //         <p style="text-align: left;">
        //             “Unhas adalah yang pertama, kita mendeklarasikan dan ini akan ketat, tidak boleh ada yang melanggar, terutama oleh senior. Cukuplah cerita pilu di tempat lain,” terangnya.
        //         </p>
        //         <p style="text-align: left;">
        //             Sementara itu, Wakil Rektor Bidang Akademik dan Kemahasiswaan Prof drg Muhammad Ruslin MKes PhD SpBM(K) dalam sambutannya mengucapkan selamat datang kepada mahasiswa baru. Ia juga menyampaikan pentingnya publikasi ilmiah sebagai bukti karya dan kontribusi pada prosesi, pekerjaan dan tentunya bagi kemajuan bangsa.
        //         </p>
        //         <p style="text-align: left;">
        //             “Unhas menerima lebih dari tiga ribu mahasiswa pascasarjana. Jika satu orang menulis satu, pasti akan memberikan dampak yang luar biasa pada keilmuan maupun profesi Anda,” ujarnya.
        //         </p>
        //         <p style="text-align: left;">
        //             Pada kesempatan ini Prof Ruslin kembali menegaskan bahwa berdasarkan regulasi, mahasiswa S2 sudah bisa selesai dengan masa studi tiga semester. Sedangkan untuk program doktor minimal 5 semester.
        //         </p>
        //         <p style="text-align: left;">
        //             “Unhas juga menyiapkan fast track untuk S2. Jadi selesai 3 semester bisa langsung lanjut S3, jadi bisa lebih singkat masa studinya,” tambahnya.
        //         </p>
        //         <p style="text-align: left;">
        //             Hadirkan Narasumber Ilmuwan
        //         </p>
        //         <p style="text-align: left;">
        //             Selain prosesi penyambutan mahasiswa baru, PKKMB pascasarjana kali ini menghadirkan dua narasumber ilmuwan yang berbagi wawasan seputar riset dan membangun jejaring.
        //         </p>
        //         <p style="text-align: left;">
        //             Dimoderatori oleh Direktur Kemahasiswaan Unhas Abdullah Sanusi PhD, sesi ini menghadirkan Roby Muhammad PhD yang merupakan anggota pendiri Akademi Ilmuwan Indonesia (ALMI) dan Hasnawaty Saleh PhD yang juga anggota pendiri ALMI.
        //         </p>
        //         <p style="text-align: left;">
        //             Bertajuk “Membangun Jejaring Riset dan Publikasi Ilmiah”, Hasnawaty Saleh menjelaskan banyak hal, mulai dari alasan mengapa harus melakukan publikasi, manfaat publikasi, jurnal bereputasi hingga bagaimana membangun jejaring.
        //         </p>
        //         <p style="text-align: left;">
        //             “Tidak ada kemajuan dalam sains kalau tidak ada publikasi. Karena bagaimana kita membagikan hasil temuan kita kepada peer terdekat kita di bidang yang sama dan tentu saja untuk memajukan peradaban,” terangnya.
        //         </p>
        //         <p style="text-align: left;">
        //             Sementara itu, dengan tema “Meneliti Jalan Menuju Keberhasilan”, Roby Muhammad menekankan tugas mahasiswa S2 dan S3 untuk fokus mengambil spesialisasi spesifik ke satu bidang tertentu.
        //         </p>
        //         <p style="text-align: left;">
        //             “Jadi harus sangat spesifik, itu yang harus dilakukan para mahasiswa pascasarjana. Jangan overthinking, harus fokus,” tegas Roby yang pernah menerima penghargaan Tokoh Penemu Nasional tahun 2012 ini.
        //         </p>
        //         <p style="text-align: left;">
        //             Setelah pemaparan materi, para peserta PKKMB antusias berdiskusi dengan pemateri.(*)
        //         </p>
        //     ',
        //     'penulis'               => 'Ahmad',
        //     'gambar'                => 'gambar/berita/99LwWXVv1TlDUssCyMepP0AmFTMKppLIcZbCqOfs.webp', // Path gambar yang relevan
        //     'deskripsi'             => ' Fakultas Kehutanan Universitas Hasanuddin (Unhas) melalui bidang Kemitraan, Riset dan Inovasi ',
        //     'total_like'            => 0,
        // ]);

        // Berita::factory()->create([
        //     'id_kategori_berita'    => 1, // Ganti ID sesuai kategori olahraga atau lomba
        //     'judul'                 => 'Lomba Lari Maraton Teknik: Kompetisi yang Mendebarkan',
        //     'slug'                  => 'lomba-lari-maraton-teknik-kompetisi-yang-mendebarkan',
        //     'konten'                => '
        //         <p style="text-align: left;">
        //             Fakultas Teknik Universitas Hasanuddin sukses mengadakan Lomba Lari Maraton Teknik pada akhir pekan lalu. Acara ini diikuti oleh ratusan mahasiswa dari berbagai jurusan yang bersemangat menunjukkan kemampuan fisik dan ketahanan mereka dalam berlari sejauh 10 kilometer.
        //         </p>
        //         <p style="text-align: left;">
        //             Lomba dimulai dari gerbang utama kampus dan berakhir di lapangan pusat kegiatan mahasiswa. Sepanjang rute, para peserta melewati berbagai titik kontrol yang telah disiapkan oleh panitia untuk memastikan keamanan dan kenyamanan para pelari.
        //         </p>
        //         <p style="text-align: left;">
        //             "Ini adalah pengalaman yang luar biasa! Saya senang bisa berpartisipasi dalam acara ini dan merasakan semangat kompetisi bersama teman-teman dari jurusan lain," ujar salah satu peserta setelah mencapai garis finish.
        //         </p>
        //         <p style="text-align: left;">
        //             Acara ini juga mendapat sambutan positif dari para penonton yang turut mendukung dan menyemangati para pelari sepanjang lomba. Pada akhirnya, para pemenang mendapatkan medali dan hadiah menarik sebagai apresiasi atas usaha mereka.
        //         </p>
        //     ',
        //     'penulis'               => 'Admin ANTEK HUB',
        //     'gambar'                => 'gambar/berita/T3D4vMqUX5xTGjeMU0yavtVYtY5K5WoJ2zBPKiVB.webp', // Path gambar yang relevan
        //     'deskripsi'             => 'Lomba Lari Maraton Teknik Universitas Hasanuddin menghadirkan kompetisi yang penuh semangat dan kebersamaan antar mahasiswa.',
        //     'total_like'            => 0,
        // ]);

        // Berita::factory()->create([
        //     'id_kategori_berita'    => 2, // Ganti ID sesuai kategori olahraga atau lomba
        //     'judul'                 => 'Unhas dan Murdoch University Gelar Workshop Internasional tentang Low Carbon Building Material',
        //     'slug'                  => 'unhas-dan-murdoch-university-gelar-workshop-internasional-tentang-low-carbon-building-material',
        //     'konten'                => '
        //         <p style="text-align: left;">
        //             Universitas Hasanuddin bekerjasama dengan Murdoch University dari Australia menyelenggarakan workshop penting bertemakan “Low Carbon Building Material.” Workshop ini bertajuk “Knowledge Exchange for Energy Transition Technology: Technology, Governance, and Industry,” yang disponsori oleh Pemerintah Australia melalui Australia-Indonesia Institute.
        //         </p>
        //         <p style="text-align: left;">
        //             Kegiatan yang berlangsung di Unhas Hotel and Convention, pada Kamis (29/8) ini dihadiri oleh para ahli dari Unhas, Todd Dias, Konsulat Jenderal Australia di Makassar, dan acqueline dari Murdoch University,, serta melibatkan ahli dari BRIN, Universitas Mataram, praktisi dari dunia usaha dan industri. Diskusi ini mencakup inovasi, tata kelola, serta tantangan regulasi terkait low carbon building materials di Indonesia.
        //         </p>
        //         <p style="text-align: left;">
        //             Dalam kesmepatan tersebut, Wakil Rektor Bidang Kemitraan, Inovasi, Kewirausahaan dan Bisnis (Prof. Dr. Eng. Adi Maulana, S.T., M.Phil) menegaskan bahwa sebagai salah satu perguruan tinggi terkemuka di Indonesia, Unhas memiliki misi penting dalam mengawal transisi energi. Murdoch University, yang merupakan salah satu entitas terkemuka di Australia dalam hal energi transisi dan tujuan pembangunan berkelanjutan, menjadi mitra ideal untuk workshop ini. Workshop ini memiliki signifikansi besar karena topik low carbon building material, atau material bangunan dengan karbon rendah, masih jarang dibahas.
        //         </p>
        //         <p style="text-align: left;">
        //             Low carbon building materials diharapkan dapat memberikan kontribusi signifikan terhadap penurunan emisi CO2. Saat ini, material bangunan menyumbang sekitar 40% dari total emisi CO2. Dalam workshop ini, akan dibahas berbagai material yang dapat digunakan untuk mengurangi emisi CO2, seperti fly ash (abu hasil pembakaran dari industri batu bara dan semen), serta limbah dari industri nikel di Sulawesi, yang merupakan penghasil nikel terbesar di dunia. Material slag dari pengelolaan nikel dapat dimanfaatkan sebagai paving block atau bahan beton, berkontribusi pada solusi ramah lingkungan.
        //         </p>
        //         <p style="text-align: left;">
        //             Selain itu, workshop ini juga akan mencakup kunjungan industri ke WICA Beton dan Kalla Beton, yakni diskusi yang berfokus pada pemanfaatan limbah dan material rendah karbon dari perspektif profit dan bisnis. Kerja sama ini diharapkan tidak hanya memberikan referensi bagi penelitian dan industri, tetapi juga menghasilkan rekomendasi untuk penerapan material bangunan rendah karbon. jelas Prof. Adi.
        //         </p>
        //         <p style="text-align: left;">
        //             “Kami mengucapkan terima kasih kepada semua pihak yang telah berkontribusi pada terselenggaranya workshop ini. Kami berharap workshop ini akan memberikan wawasan berharga dan rekomendasi yang bermanfaat dalam penerapan material bangunan rendah karbon, serta semakin memperkuat posisi Unhas sebagai universitas terdepan dalam mendukung tujuan pembangunan berkelanjutan, mengatasi perubahan iklim, dan transisi energi menuju zero net emission,” jelas Prof. Adi.
        //         </p>',
        //     'penulis'               => 'Ahmad',
        //     'gambar'                => 'gambar/berita/vF7rDFdbij4bEMsantvxVKpzgmWy99SOIe5sqvuC.webp', // Path gambar yang relevan
        //     'deskripsi'             => 'Universitas Hasanuddin bekerjasama dengan Murdoch University dari Australia menyelenggarakan workshop',
        //     'total_like'            => 0,
        // ]);

        // User::factory(20)->create();
        // JenjangPendidikan::factory(200)->create();
        // KategoriBerita::factory(12)->create();
        // Berita::factory(100)->create();
        // Perusahaan::factory(1)->create();
        // Loker::factory(30)->create();
        // Event::factory(3)->create();
        // peserta_event::factory(20)->create();
        // jurusan::factory(16)->create();
        // StatistikPendidikan::factory(5)->create();

        // sometimes error, paksami saja
        // Like::factory(400)->create();

        // kalau mau run banyak data, uncomment ini, comment yang lain
        Alumni::factory(20)->create();
    }
}
