<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Games::factory()->create([
            'nama_games' => 'Mobile Legend',
            'kapasitas' => 50
        ]);
        \App\Models\Games::factory()->create([
            'nama_games' => 'PUBG',
            'kapasitas' => 50
        ]);
        \App\Models\Games::factory()->create([
            'nama_games' => 'Valorant',
            'kapasitas' => 50
        ]);
    }
}
