<?php

namespace App\Http\Controllers\Permisos;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
class RolesController extends ApiController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $roles=Role::all();
      $roles->each(function ($roles){
        $roles->givePermissionTo();
      });
      return $this->showAll($roles);
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

      $role = Role::create(['name' => $request->name ]);
      $role->syncPermissions ($request->permisos);

      return $this->success('Rol creado con éxito',201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Rol  $Rol
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $rol=Role::findOrFail($id);
        return $this->success($rol,200);
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Rol  $Rol
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request,$id)
  {
      $rol=Role::findOrFail($id);
      $rol->syncPermissions($request->permissions);
      return $this->success($rol,200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Rol  Rol
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $rol=Role::findOrFail($id);
      $rol->delete();
      return $this->success('Elininación éxitosa',201);
  }
}
