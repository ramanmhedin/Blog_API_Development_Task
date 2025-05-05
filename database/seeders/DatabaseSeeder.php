<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $userExist=User::query()->where("email","test@example.com")->exists();
        //create a user when it does not exist
        User::factory()->when(!$userExist)->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' =>Hash::make("password")
        ]);


        $this->call([
            CategorySeeder::class,
            PostSeeder::class,
        ]);
    }
}
