<?php

namespace Database\Seeders;

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
        $this->call([
            RoleSeeder::class
        ]);


        \App\Models\User::factory()->create();

        \App\Models\User::first()->roles()->attach(3);
        
        \App\Models\Contact::factory()->create();

      

    }
}
