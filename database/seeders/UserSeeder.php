<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'username' => 'Admin',
            'password' => Hash::make('Admin12345!'),
            'role' => 'pengurus'
        ]);

        \App\Models\User::factory()->create([
            'username' => 'PJUnisec',
            'password' => Hash::make('PJ12345!'),
            'role' => 'PJ'
        ]);
    }
}
