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
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->unsignedTinyInteger('id_kategori_berita');
            $table->foreign('id_kategori_berita')->references('id_kategori_berita')->on('kategori_berita')->onDelete('set null');
            $table->string('judul');
            $table->string('penulis');
            $table->string('slug', 255);
            $table->string('gambar', 100);
            $table->mediumText('konten');
            $table->string('deskripsi');
            $table->integer('total_like')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
};
