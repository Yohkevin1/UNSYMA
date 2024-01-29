<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiNames = [
            'Arsitektur',
            'Teknik Sipil',
            'Manajemen',
            'Akuntansi',
            'Ilmu Hukum',
            'Teknik Industri',
            'Informatika',
            'Biologi',
            'Ilmu Komunikasi',
            'Sosiologi',
            'Ekonomi Pembangunan',
            'Manajemen Internasional',
            'Teknik Sipil Internasional',
            'Teknik Industri Internasional',
            'Akuntansi Internasional',
            'Sistem Informasi',
            'Teknologi Pangan'
        ];

        foreach ($prodiNames as $prodiName) {
            \App\Models\ProgramStudi::factory()->create([
                'nama_prodi' => $prodiName,
            ]);
        }
    }
}
