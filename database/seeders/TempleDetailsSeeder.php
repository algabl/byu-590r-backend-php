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
            'square_footage' => 85084,
            'number_ordinance_rooms' => 2,
            'number_sealing_rooms' => 5,
            'number_surface_parking_spots' => 50,
            'additional_notes' => 'Additional notes about the temple.',
        ]);

        $paysonTemple = Temple::where('name', 'Payson Utah Temple')->first();
        TempleDetails::create([
            'temple_id' => $paysonTemple->id,
            'architect' => 'Architect Name',
            'square_footage' => 85084,
            'number_ordinance_rooms' => 2,
            'number_sealing_rooms' => 5,
            'number_surface_parking_spots' => 50,
            'additional_notes' => 'Additional notes about the temple.',
        ]);
        $manhattanTemple = Temple::where('name', 'Manhattan New York Temple')->first();
        TempleDetails::create([
            'temple_id' => $manhattanTemple->id,
            'architect' => 'Architect Name',
            'square_footage' => 85084,
            'number_ordinance_rooms' => 2,
            'number_sealing_rooms' => 5,
            'number_surface_parking_spots' => 50,
            'additional_notes' => 'Additional notes about the temple.',
        ]);
        $saltLakeTemple = Temple::where('name', 'Salt Lake Temple')->first();
        TempleDetails::create([
            'temple_id' => $saltLakeTemple->id,
            'architect' => 'Architect Name',
            'square_footage' => 85084,
            'number_ordinance_rooms' => 2,
            'number_sealing_rooms' => 5,
            'number_surface_parking_spots' => 50,
            'additional_notes' => 'Additional notes about the temple.',
        ]);
        $philadelphiaTemple = Temple::where('name', 'Philadelphia Pennsylvania Temple')->first();
        TempleDetails::create([
            'temple_id' => $philadelphiaTemple->id,
            'architect' => 'Architect Name',
            'square_footage' => 85084,
            'number_ordinance_rooms' => 2,
            'number_sealing_rooms' => 5,
            'number_surface_parking_spots' => 50,
            'additional_notes' => 'Additional notes about the temple.',
        ]);
        $templeDetails = TempleDetails::all();
        foreach ($templeDetails as $templeDetail) {
            $templeDetail->temple->templeDetails = $templeDetail;
        }

    }
}
