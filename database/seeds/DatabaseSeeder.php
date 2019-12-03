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
        factory('App\User')->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        factory('App\User')->create(['name' => 'Jane Doe', 'email' => 'jane@example.com']);
        factory('App\User')->create(['name' => 'Mary Jane', 'email' => 'mary@example.com']);
        factory('App\User')->create(['name' => 'Harry', 'email' => 'harry@example.com']);
        factory('App\User')->create(['name' => 'Tom', 'email' => 'tom@example.com']);
    }
}
