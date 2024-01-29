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
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->increments('id_pertemuan');
            $table->string('meet', 50);
            $table->unsignedInteger('id_ta');
            $table->unsignedInteger('id_games');
            $table->dateTime('opened');
            $table->dateTime('closed');
            $table->timestamps();
            $table->softDeletesDatetime('deleted_at');

            $table->foreign('id_ta')->references('id_ta')->on('tahun_akademik');
            $table->foreign('id_games')->references('id_games')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan');
    }
};
