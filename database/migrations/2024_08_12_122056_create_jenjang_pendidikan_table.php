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
        Schema::create('jenjang_pendidikan', function (Blueprint $table) {
            $table->id('id_jenjang_pendidikan');

            $table->unsignedTinyInteger('id_alumni');
            $table->foreign('id_alumni')->references('id_alumni')->on('alumni')->onDelete('cascade');

            $table->string('jenjang'); //s1, s2, ppi, ppa
            $table->string('nim')->nullable(); // D14 19 024
            $table->string('jurusan');
            $table->string('angkatan', 4);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenjang_pendidikan');
    }
};
