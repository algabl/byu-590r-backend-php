<?php

namespace Database\Seeders;

use App\Models\Temple;
use App\Models\TempleEvent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempleEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $provoTemple = Temple::where('name', 'Provo City Center Temple')->first();
        TempleEvent::create([
            'name' => 'Provo City Center Temple Open House',
            'date' => '2025-05-01 10:00:00',
            'description' => 'Join us for an open house at the Provo City Center Temple.',
            'temple_id' => $provoTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Provo City Center Temple Dedication',
            'date' => '2025-06-01 10:00:00',
            'description' => 'Join us for the dedication of the Provo City Center Temple.',
            'temple_id' => $provoTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Provo City Center Temple Youth Night',
            'date' => '2025-07-01 18:00:00',
            'description' => 'Join us for a youth night at the Provo City Center Temple.',
            'temple_id' => $provoTemple->id,
        ]);

        $manhattanTemple = Temple::where('name', 'Manhattan New York Temple')->first();
        TempleEvent::create([
            'name' => 'Manhattan New York Temple Open House',
            'date' => '2025-05-01 10:00:00',
            'description' => 'Join us for an open house at the Manhattan New York Temple.',
            'temple_id' => $manhattanTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Manhattan New York Temple Dedication',
            'date' => '2025-06-01 10:00:00',
            'description' => 'Join us for the dedication of the Manhattan New York Temple.',
            'temple_id' => $manhattanTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Manhattan New York Temple Youth Night',
            'date' => '2025-07-01 18:00:00',
            'description' => 'Join us for a youth night at the Manhattan New York Temple.',
            'temple_id' => $manhattanTemple->id,
        ]);
    }
}
