<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 9 user random
        $users = User::factory(9)->create();

        // Buat 1 user tetap (Test User)
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Gabungkan semua user
        $allUsers = $users->push($testUser);

        // Setiap user memiliki 50 task
        foreach ($allUsers as $user) {
            Task::factory()->count(50)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
