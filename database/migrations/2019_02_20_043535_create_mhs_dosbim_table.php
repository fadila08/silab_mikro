<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMhsDosbimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhs_dosbim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mhs')->unsigned()->index();
            $table->integer('id_dosbim')->unsigned()->index();
            $table->integer('id_kelas')->unsigned()->nullable()->index();
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
        Schema::dropIfExists('mhs_dosbim');
    }
}
