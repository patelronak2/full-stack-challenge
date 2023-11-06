<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create([
             'name' => 'John Doe',
             'email' => 'admin@mail.com',
         ]);

        Company::factory()
            ->count(5)
            ->has(
                Job::factory()->count(4)
            )->create();
    }
}
