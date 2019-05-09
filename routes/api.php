<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




// =============================================================================
// PUBLIC ROUTES
// =============================================================================

// Route::get('galeri/link','GaleriController@link');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// AUTH CONTROL
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::post('logout', function(){
    return response()->json([
        'message' => 'ok'
    ]);
});

//MAHASISWA
Route::apiResource('mahasiswa', 'DataMahasiswaController', ['parameters' => [
'mahasiswa' => 'user'
]])->only('index','show');

//LABORAN
Route::apiResource('laboran', 'DataLaboranController', ['parameters' => [
'laboran' => 'user'
]])->only('index','show');

//KALAB
Route::apiResource('kalab', 'DataKalabController', ['parameters' => [
'kalab' => 'user'
]])->only('index','show');

//DOSEN
Route::apiResource('dosen', 'DataDosenController', ['parameters' => [
'dosen' => 'user'
]])->only('index','show');

//ASLAB
Route::apiResource('aslab', 'DataAslabController', ['parameters' => [
'aslab' => 'user'
]])->only('index','show');



// ADDITIONAL
Route::apiResource('datapengumuman', 'PengumumanController')->only('index','show');
Route::get('pengumuman/downloadlampiran/{id}', 'PengumumanController@downloadLampiran');

Route::apiResource('datagaleri', 'GaleriController')->only('index','show');

Route::get('unduhan/read', 'UnduhanController@read'); 
Route::get('unduhan/download/{id}', 'UnduhanController@download');

// FILTER
Route::get('filter', 'FilterController@index');



// ===============================================
// PRIVATE ROUTE
// ===============================================

// Routes Setelah login (authenticated)
Route::group(['middleware' => ['jwt.verify']], function() {
  // get user data
	Route::get('me', 'UserController@getAuthenticatedUser');

  // other..

	Route::apiResources([
		'dosbim' => 'DosbimController',
		'kelas' => 'KelasController'
	]);
	Route::post('dosbim/import', 'DosbimController@import');

	//MAHASISWA
	Route::apiResource('datamahasiswa', 'DataMahasiswaController', ['parameters' => [
    'datamahasiswa' => 'user'
	]]);
	Route::post('datamahasiswa/import', 'DataMahasiswaController@import');

	//LABORAN
	Route::apiResource('datalaboran', 'DataLaboranController', ['parameters' => [
    'datalaboran' => 'user'
	]]);
	
	//KALAB
	Route::apiResource('datakalab', 'DataKalabController', ['parameters' => [
    'datakalab' => 'user'
	]]);
	
	//DOSEN
	Route::apiResource('datadosen', 'DataDosenController', ['parameters' => [
    'datadosen' => 'user'
	]]);

	//ASLAB
	Route::apiResource('dataaslab', 'DataAslabController', ['parameters' => [
    'dataaslab' => 'user'
	]]);
	
	//NILAI
	Route::apiResource('nilai', 'NilaiController');

	//KELAS
	Route::apiResource('kelas', 'KelasController');

	//PRAKTIKUM
	Route::apiResource('praktikum', 'PraktikumController');
	
	//ABSENSI
	Route::apiResource('absensi', 'AbsensiController');


	// ADDITIONAL RESOURCES
	Route::apiResource('pengumuman', 'PengumumanController')->except('index','show');
	Route::apiResource('galeri', 'GaleriController')->except('index','show','update');

	Route::delete('unduhan/delete/{id}', 'UnduhanController@delete'); 
	Route::post('unduhan/insert', 'UnduhanController@insert');  
	Route::put('unduhan/update/{id}', 'UnduhanController@update');

});