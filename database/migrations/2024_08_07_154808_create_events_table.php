<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('id_event');

            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->string('gambar', 255)->nullable();
            $table->mediumText('konten');
            $table->string('deskripsi');
            $table->string('penyelenggara');
            $table->date('tgl_event');
            $table->string('lokasi_event', 255);
            $table->integer('kuota');
            $table->integer('peserta')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
