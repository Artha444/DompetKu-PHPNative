<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first();
        $defaults = [
            ['name' => 'Gaji', 'type' => 'income', 'color' => '#10B981'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#34D399'],
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#EF4444'],
            ['name' => 'Transportasi', 'type' => 'expense', 'color' => '#F59E0B'],
            ['name' => 'Tagihan', 'type' => 'expense', 'color' => '#8B5CF6'],
            ['name' => 'Belanja', 'type' => 'expense', 'color' => '#EC4899'],
        ];

        foreach ($defaults as $d) {
            $user->categories()->create($d);
        }
    }
}
