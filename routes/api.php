<?php

use Illuminate\Http\Request;
use App\User;
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
Route::get('usuario', 'Auth\AuthController@user');
/***Ruats para logeo***/
Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::post('registro', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('actualizar', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('logout', 'AuthController@logout');
    });
});

Route::middleware(['auth:api'])->group( function () {
    Route::get('permisos-usuario', 'Auth\AuthController@userPermisos');
    Route::namespace('Permisos')->group(function () {
      /**Ruras para roles**/
      Route::post('roles','RolesController@store')->name('roles.store')->middleware('permisos:roles.store');
      Route::get('roles/{id}','RolesController@show')->name('roles.show')->middleware('permisos:roles.show');
      Route::put('roles/{id}','RolesController@update')->name('roles.update')->middleware('permisos:roles.update');
      Route::delete('roles/{id}','RolesController@destroy')->name('roles.destroy')->middleware('permisos:roles.destroy');
      Route::get('roles','RolesController@index')->name('roles.index')->middleware('permisos:roles.index');

      /**Ruras para permisos**/
      Route::post('permisos','PermisosController@store')->name('permisos.store');//->middleware('permisos:permisos.store');
      Route::get('permisos/{id}','PermisosController@show')->name('permisos.show');//->middleware('permisos:permisos.show');
      Route::put('permisos/{id}','PermisosController@update')->name('permisos.update');//->middleware('permisos:permisos.update');
      Route::delete('permisos/{id}','PermisosController@destroy')->name('permisos.destroy');//->middleware('permisos:permisos.destroy');
      Route::get('permisos','PermisosController@index')->name('permisos.index');//->middleware('permisos:permisos.index');
    });


    /**Rutas para Usuarios **/

    Route::post('usuarios','Usuarios\UsuariosController@store')->name('usuarios.store')->middleware('permisos:usuarios.store');
    Route::get('usuarios/{usuario}','Usuarios\UsuariosController@show')->name('usuarios.show')->middleware('permisos:usuarios.show');
    Route::put('usuarios/{usuario}','Usuarios\UsuariosController@update')->name('usuarios.update')->middleware('permisos:usuarios.update');
    Route::delete('usuarios/{usuario}','Usuarios\UsuariosController@destroy')->name('usuarios.destroy')->middleware('permisos:usuarios.destroy');
    Route::get('usuarios','Usuarios\UsuariosController@index')->name('usuarios.index')->middleware('permisos:usuarios.index');

    Route::namespace('Productos')->group(function () {

      Route::post('productos','ProductosController@store')->name('productos.store')->middleware('permisos:usuarios.store');
      Route::get('productos/{usuario}','ProductosController@show')->name('productos.show')->middleware('permisos:usuarios.show');
      Route::put('productos/{usuario}','ProductosController@update')->name('productos.update')->middleware('permisos:usuarios.update');
      Route::delete('productos/{usuario}','ProductosController@destroy')->name('productos.destroy')->middleware('permisos:usuarios.destroy');
      Route::get('productos','ProductosController@index')->name('productos.index')->middleware('permisos:usuarios.index');

    });

});
