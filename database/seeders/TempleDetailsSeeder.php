<?php

namespace Database\Seeders;

use App\Models\Temple;
use App\Models\TempleDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempleDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provoTemple = Temple::where('name', 'Provo City Center Temple')->first();
        TempleDetails::create([
            'temple_id' => $provoTemple->id,
            'architect' => 'Architect Name',
            'square_footage' => 10000,
            'number_ordinance_rooms' => 2,
            'number_sealing_rooms' => 3,
            'number_surface_parking_spots' => 50,
            'additional_notes' => 'Additional notes about the temple.',
        ]);
    }
}
