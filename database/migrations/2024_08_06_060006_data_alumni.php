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
            $table->id("id_alumni");
            $table->string('nim', 50);
            $table->string('nama', 100);
            $table->date('tgl_lahir');
            $table->string('jurusan');
            $table->integer('angkatan')->length(4);
            $table->enum('kelamin', ['l', 'p']);
            $table->enum('agama', [
                'Islam', 
                'Kristen Protestan', 
                'Kristen Katolik', 
                'Hindu', 
                'Buddha', 
                'Konghucu'
            ]);
            $table->enum('golongan_darah', [
                'A+', 
                'A-', 
                'B+', 
                'B-', 
                'O+', 
                'O-', 
                'AB+', 
                'AB-'
            ]);
            $table->boolean('validated');
            $table->integer('id_user');
            $table->foreign('id_user');
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
