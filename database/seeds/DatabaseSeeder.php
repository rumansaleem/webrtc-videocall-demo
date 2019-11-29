<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User')->create(['name' => 'Ruman Saleem', 'email' => 'ruman63@example.com']);
        factory('App\User')->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    }
}
