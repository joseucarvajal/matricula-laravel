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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('departamento/departamentos', 'Departamento\\DepartamentosController');
Route::resource('ciudad/ciudads', 'Ciudad\\CiudadsController');
Route::resource('ciudad/ciudads', 'Ciudad\\CiudadsController');
Route::resource('ciudad/ciudads', 'Ciudad\\CiudadsController');
Route::resource('matricula/matriculas', 'Matricula\\MatriculasController');

Route::post('ciudad/ciudads/ciudadesByDepartamento', 'Ciudad\\CiudadsController@ciudadesByDepartamento');

Route::post('/ciudadesByDepartamento', array('as'=>'get-ciudades','uses'=>'CiudadsController@ciudadesByDepartamento'));