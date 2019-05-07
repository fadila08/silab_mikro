<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mhs')->unsigned()->index();
            $table->integer('id_kelas')->unsigned()->nullable()->index();
            $table->float('tugas_pendahuluan_1');
            $table->float('tugas_pendahuluan_2');
            $table->float('tugas_pendahuluan_3');
            $table->float('tugas_pendahuluan_4');
            $table->float('abstrak_praktikum_1');
            $table->float('abstrak_praktikum_2');
            $table->float('abstrak_praktikum_3');
            $table->float('abstrak_praktikum_4');
            $table->float('aktivitas_praktikum_1');
            $table->float('aktivitas_praktikum_2');
            $table->float('aktivitas_praktikum_3');
            $table->float('aktivitas_praktikum_4');
            $table->float('tugas_paska_praktikum_1');
            $table->float('tugas_paska_praktikum_2');
            $table->float('tugas_paska_praktikum_3');
            $table->float('tugas_paska_praktikum_4');
            $table->float('tes_akhir');
            $table->float('nilai_bimbingan_dosen');
            $table->boolean('status_laporan');
            $table->float('nilai_akhir');
            $table->string('grade');
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
        Schema::dropIfExists('nilai');
    }
}
