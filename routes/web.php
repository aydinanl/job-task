<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', [ 'uses' => 'ExportController@welcome', 'as' => 'home'] );
Route::get('view', [ 'uses' => 'ExportController@viewStudents', 'as' => 'view'] );
Route::get('export', [ 'uses' => 'ExportController@export', 'as' => 'export'] );

/* Actions */
//Export All Students as CSV
Route::get('export/attendance', [ 'uses' => 'ExportController@exportStudentsToCSV', 'as' => 'exportAll'] );
//Export Selected Students as CSV
Route::post('export', [ 'uses' => 'ExportController@exportStudentsToCSV', 'as' => 'exportSelected'] );
