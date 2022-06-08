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
        $professions = \App\Models\Profession::factory(10)->create();

        \App\Models\Person::factory(100)
            ->hasContacts(3)
            ->hasUsers(1)
            ->create()
            ->each(function ($person) use ($professions) {
                $person->professions()->attach($professions->random());
            });
    }
}
