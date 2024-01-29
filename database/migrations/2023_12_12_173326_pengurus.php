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
        Schema::create('pengurus', function (Blueprint $table) {
            $table->increments('id_pengurus', 11);
            $table->string('npm', 20);
            $table->string('nama', 100);
            $table->string('gender', 20);
            $table->unsignedInteger('id_prodi');
            $table->string('no_hp', 15);
            $table->string('email', 50);
            $table->string('jabatan', 50);
            $table->unsignedInteger('id_ta');
            $table->timestamps();
            $table->softDeletesDatetime('deleted_at');

            $table->foreign('id_ta')->references('id_ta')->on('tahun_akademik');
            $table->foreign('id_prodi')->references('id_prodi')->on('prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus');
    }
};
