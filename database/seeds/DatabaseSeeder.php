<?php

use Illuminate\Database\Seeder;
use App\User;
class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      User::truncate();
      //factory(User::class,20)->create();
      $this->call(UsersTableSeeder::class);
      $this->call(ProductsTableSeeder::class);
      $this->call(PermissionsTableSeeder::class);
    }
}
