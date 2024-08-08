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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 50);
            $table->enum('kelamin', ['l', 'p']);
            $table->string('nama', 100);
			$table->string('no_telp', 20)->unique()->nullable();
            $table->date('tgl_lahir');
            $table->enum('jurusan', ['informatika', 'teknik mesin']);
            $table->integer('angkatan')->length(4);
            $table->enum('golongan_darah', ['a', 'o', 'b', 'ab']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
