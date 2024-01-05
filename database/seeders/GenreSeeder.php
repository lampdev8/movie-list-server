<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    private const GENRES = [
        'action',
        'comedy',
        'drama',
        'fantasy',
        'horror',
        'mystery',
        'romance',
        'thriller',
        'western',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nowDate = new \DateTime('now');

        foreach (self::GENRES as $genre) {
            DB::table('genres')->insert([
                'name' => $genre,
                'created_at' => $nowDate,
                'updated_at' => $nowDate,
            ]);
        }
    }
}
