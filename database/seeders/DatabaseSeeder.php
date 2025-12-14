<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user = \App\Models\User::first();

        $defaults = [
            ['name' => 'Gaji', 'type' => 'income', 'color' => '#10B981'],
            ['name' => 'Bonus', 'type' => 'income', 'color' => '#34D399'],
            ['name' => 'Makan', 'type' => 'expense', 'color' => '#EF4444'],
            ['name' => 'Transport', 'type' => 'expense', 'color' => '#F59E0B'],
            ['name' => 'Tagihan', 'type' => 'expense', 'color' => '#8B5CF6'],
            ['name' => 'Belanja', 'type' => 'expense', 'color' => '#EC4899'],
        ];

        foreach ($defaults as $cat) {
            $user->categories()->create($cat);
        }
    }
}
