<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('loker', function (Blueprint $table) {
            $table->id('id_loker');
            $table->string('judul')->unique();
            $table->string('slug');
            $table->string('gambar');
            $table->mediumText('konten');
            $table->string('perusahaan');
            $table->date('tgl_selesai'); // tanggal loker tampil 
            $table->string('lokasi'); // kota
            $table->tinyText('pengalaman_kerja');
            $table->string('posisi');
            $table->string('role');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loker');
    }
};
