<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Permission::create(['name'=>'usuarios.index']);
      Permission::create(['name'=>'usuarios.show']);
      Permission::create(['name'=>'usuarios.update']);
      Permission::create(['name'=>'usuarios.destroy']);

      //rolles
      Permission::create(['name'=>'roles.index']);
      Permission::create(['name'=>'roles.store']);
      Permission::create(['name'=>'roles.show']);
      Permission::create(['name'=>'roles.update']);
      Permission::create(['name'=>'roles.destroy']);

      //db roles
      $adminRoles=Role::create(['name'=>'AdminRoles']);

       $adminRoles->givePermissionTo([
           'roles.index',
           'roles.store',
           'roles.show',
           'roles.update',
           'roles.destroy'
       ]);
       //$admin->givePermissionTo('products.index');
       //$admin->givePermissionTo(Permission::all());

       //Guest
       $adminUsuarios = Role::create(['name' => 'AdminUsuarios']);

       $adminUsuarios->givePermissionTo([
         'usuarios.index',
         'usuarios.show',
         'usuarios.update',
         'usuarios.destroy'
       ]);

       //User Admin
       

    }
}
