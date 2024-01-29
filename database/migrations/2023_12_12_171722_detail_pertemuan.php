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
        Schema::create('detail_pertemuan', function (Blueprint $table) {
            $table->unsignedInteger('id_pertemuan');
            $table->unsignedInteger('id_anggota');
            $table->string('foto', 255)->nullable();
            $table->enum('status', ['Hadir', 'Izin', 'Alpha']);
            $table->dateTime('verifikasi')->nullable();
            $table->timestamps();
            $table->softDeletesDatetime('deleted_at');

            $table->foreign('id_pertemuan')->references('id_pertemuan')->on('pertemuan');
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pertemuan');
    }
};
