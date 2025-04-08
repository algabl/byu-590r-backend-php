<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Temple;

class TempleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temples = [
            [
                'name' => 'Provo City Center Temple',
                'latitude' => 40.2338,
                'longitude' => -111.6585,
                'status' => 'Open',
                'walk_score' => 50,
                'bike_score' => 60,
                'transit_score' => 70,
            ],
            [
                'name' => 'Payson Utah Temple',
                'latitude' => 40.0444,
                'longitude' => -111.7321,
                'status' => 'Open',
                'walk_score' => 40,
                'bike_score' => 50,
                'transit_score' => 60,
            ],
            [
                'name' => 'Manhattan New York Temple',
                'latitude' => 40.7676,
                'longitude' => -73.9712,
                'status' => 'Open',
                'walk_score' => 90,
                'bike_score' => 80,
                'transit_score' => 70,
            ],
            [
                'name' => 'Salt Lake Temple',
                'latitude' => 40.7704,
                'longitude' => -111.8910,
                'status' => 'Open',
                'walk_score' => 80,
                'bike_score' => 70,
                'transit_score' => 60,
            ],
            [
                'name' => 'Philadelphia Pennsylvania Temple',
                'latitude' => 40.0839,
                'longitude' => -75.0435,
                'status' => 'Open',
                'walk_score' => 70,
                'bike_score' => 60,
                'transit_score' => 50,
            ]
        ];
        Temple::insert($temples);
    }
}
