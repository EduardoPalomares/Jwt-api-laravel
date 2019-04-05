<?php

namespace App\Http\Controllers\Permisos;

use Spatie\Permission\Models\Permission as Permiso;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
class PermisosController extends ApiController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $permisos=Permiso::all();
      return $this->showAll($permisos);
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Permiso  $Permiso
   * @return \Illuminate\Http\Response
   */
  public function show(Permiso $permiso)
  {
      //
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Permiso  $Permiso
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Permiso $permiso)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Permiso  $Permiso
   * @return \Illuminate\Http\Response
   */
  public function destroy(Permiso $permiso)
  {
      //
  }
}
