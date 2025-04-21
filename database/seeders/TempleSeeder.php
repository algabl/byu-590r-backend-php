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
                'walk_score' => 88,
                'bike_score' => 74,
                'transit_score' => 51,
            ],
            [
                'name' => 'Payson Utah Temple',
                'latitude' => 40.0188,
                'longitude' => -111.7484,
                'status' => 'Open',
                'walk_score' => 20,
                'bike_score' => 27,
                'transit_score' => 18,
            ],
            [
                'name' => 'Manhattan New York Temple',
                'latitude' => 40.7676,
                'longitude' => -73.9712,
                'status' => 'Closed for Renovation',
                'walk_score' => 100,
                'bike_score' => 86,
                'transit_score' => 100,
            ],
            [
                'name' => 'Salt Lake Temple',
                'latitude' => 40.7704,
                'longitude' => -111.8910,
                'status' => 'Closed for Renovation',
                'walk_score' => 91,
                'bike_score' => 94,
                'transit_score' => 70,
            ],
            [
                'name' => 'Philadelphia Pennsylvania Temple',
                'latitude' => 40.0839,
                'longitude' => -75.0435,
                'status' => 'Open',
                'walk_score' => 96,
                'bike_score' => 84,
                'transit_score' => 100,
            ]
        ];
        Temple::insert($temples);
    }
}
