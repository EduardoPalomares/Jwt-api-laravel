<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      App\User::create([
           'nombre'      => 'Eduardo Palomares',
           'email'     => 'eduardo@exite.com.mx',
           'email_verified_at' => now(),
           'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
           'remember_token' => Str::random(10)

       ]);

       factory(App\User::class, 9)->create();
    }
}
