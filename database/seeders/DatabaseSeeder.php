<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory(20)->create();
        $this->call(UserSeeder::class);
        \App\Models\Event::factory(10)->create();
        \App\Models\Invitation::factory(40)->create();
        \App\Models\UserEventAccess::factory(20)->create();
        \App\Models\EventPhotographer::factory(20)->create();
        $this->call(ProfilePhotoSeeder::class);
        $this->call(NumberContactSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
