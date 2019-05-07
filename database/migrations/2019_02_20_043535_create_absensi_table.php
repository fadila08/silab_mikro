<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mhs')->unsigned()->index();
            $table->integer('id_kelas')->unsigned()->nullable()->index();
            $table->boolean('pertemuan_1');
            $table->boolean('pertemuan_2');
            $table->boolean('pertemuan_3');
            $table->boolean('pertemuan_4');
            $table->integer('presentase');
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
        Schema::dropIfExists('absensi');
    }
}
