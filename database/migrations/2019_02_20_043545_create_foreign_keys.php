<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		// Schema::table('users', function(Blueprint $table) {
		// 	$table->foreign('id_roles')->references('id')->on('roles')
		// 				->onDelete('restrict')
		// 				->onUpdate('restrict');
		// });
		Schema::table('kelas', function(Blueprint $table) {
			$table->foreign('id_praktikum')->references('id')->on('praktikum')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('tugas_praktikum', function(Blueprint $table) {
			$table->foreign('id_mhs')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('tugas_praktikum', function(Blueprint $table) {
			$table->foreign('id_kelas')->references('id')->on('kelas')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('mhs_dosbim', function(Blueprint $table) {
			$table->foreign('id_mhs')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('mhs_dosbim', function(Blueprint $table) {
			$table->foreign('id_dosbim')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('mhs_dosbim', function(Blueprint $table) {
			$table->foreign('id_kelas')->references('id')->on('kelas')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('nilai', function(Blueprint $table) {
			$table->foreign('id_mhs')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('nilai', function(Blueprint $table) {
			$table->foreign('id_kelas')->references('id')->on('kelas')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('surat', function(Blueprint $table) {
			$table->foreign('id_mhs')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('surat', function(Blueprint $table) {
			$table->foreign('id_kelas')->references('id')->on('kelas')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('histori', function(Blueprint $table) {
			$table->foreign('id_user')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('absensi', function(Blueprint $table) {
			$table->foreign('id_mhs')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('absensi', function(Blueprint $table) {
			$table->foreign('id_kelas')->references('id')->on('kelas')
						->onDelete('set null')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		// Schema::table('users', function(Blueprint $table) {
		// 	$table->dropForeign('users_id_roles_foreign');
		// });
		Schema::table('kelas', function(Blueprint $table) {
			$table->dropForeign('kelas_id_praktikum_foreign');
		});
		Schema::table('tugas_praktikum', function(Blueprint $table) {
			$table->dropForeign('tugas_praktikum_id_mhs_foreign');
		});
		Schema::table('tugas_praktikum', function(Blueprint $table) {
			$table->dropForeign('tugas_praktikum_id_kelas_foreign');
		});
		Schema::table('mhs_dosbim', function(Blueprint $table) {
			$table->dropForeign('mhs_dosbim_id_mhs_foreign');
		});
		Schema::table('mhs_dosbim', function(Blueprint $table) {
			$table->dropForeign('mhs_dosbim_id_dosbim_foreign');
		});
		Schema::table('mhs_dosbim', function(Blueprint $table) {
			$table->dropForeign('mhs_dosbim_id_kelas_foreign');
		});
		Schema::table('nilai', function(Blueprint $table) {
			$table->dropForeign('nilai_id_mhs_foreign');
		});
		Schema::table('nilai', function(Blueprint $table) {
			$table->dropForeign('nilai_id_kelas_foreign');
		});
		Schema::table('surat', function(Blueprint $table) {
			$table->dropForeign('surat_id_mhs_foreign');
		});
		Schema::table('surat', function(Blueprint $table) {
			$table->dropForeign('surat_id_kelas_foreign');
		});
		Schema::table('histori', function(Blueprint $table) {
			$table->dropForeign('histori_id_user_foreign');
		});
		Schema::table('absensi', function(Blueprint $table) {
			$table->dropForeign('absensi_id_mhs_foreign');
		});
		Schema::table('absensi', function(Blueprint $table) {
			$table->dropForeign('absensi_id_kelas_foreign');
		});
	}
}