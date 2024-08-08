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
        Schema::create('kategori_berita', function (Blueprint $table) {
            $table->id('id_kategori_berita');
            $table->string('kategori', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_berita');
    }
};
