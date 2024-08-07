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
            $table->id();
            $table->foreignId('id_kategori')->constrained('kategori_berita');
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->string('gambar', 255)->nullable();
            $table->text('konten');
            $table->integer('total_like')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
};
