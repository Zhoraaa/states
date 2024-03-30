<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Factories\UserFactory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'login' => 'Admin',
            'email' => 'admin@admin',
            'email_verified_at' => null,
            'password' => bcrypt('Admin1!'),
            'remember_token' => null,
            'role' => 1,
            'banned' => 0,
        ]);
        User::factory()->create([
            'login' => 'testAcc',
            'email' => 'test@acc.fake',
            'email_verified_at' => null,
            'password' => bcrypt('testAcc1!'),
            'remember_token' => null,
            'role' => 3,
            'banned' => 0,
        ]);
        User::factory()->count(13)->create();
    }
}
