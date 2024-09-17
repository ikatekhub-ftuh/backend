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
            $table->id('id_alumni');
            $table->unsignedBigInteger('id_user')->nullable()->unique();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('set null');
            // $table->string('nim', 20)->nullable();
            $table->string('no_anggota', 10)->unique()->nullable();
            $table->string('nama', 100);
            $table->date('tgl_lahir')->nullable();
            // $table->tinyText('jurusan');
            $table->string('no_telp', 20)->nullable();
            // $table->string('angkatan', 4);
            $table->enum('kelamin', ['l', 'p']);
            $table->enum('agama', [
                'Islam',
                'Kristen Protestan',
                'Kristen Katolik',
                'Hindu',
                'Buddha',
                'Konghucu'
            ])->nullable();
            $table->enum('golongan_darah', [
                'A+',
                'A-',
                'B+',
                'B-',
                'O+',
                'O-',
                'AB+',
                'AB-'
            ])->nullable();
            $table->boolean('validated')->default(false);
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
