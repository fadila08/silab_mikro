<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTugasPraktikumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_praktikum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_kelas')->unsigned()->nullable()->index();
            $table->integer('id_mhs')->unsigned()->index();
            $table->string('judul');
            $table->binary('tugas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas_praktikum');
    }
}
