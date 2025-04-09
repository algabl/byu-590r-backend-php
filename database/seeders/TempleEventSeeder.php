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
            'name' => 'Announcement',
            'date' => '2011-10-01 00:00:00',
            'description' => 'The Provo City Center Temple was announced.',
            'temple_id' => $provoTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Groundbreaking',
            'date' => '2012-05-12 00:00:00',
            'description' => 'The groundbreaking ceremony for the Provo City Center Temple was held.',
            'temple_id' => $provoTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Open House',
            'date' => '2016-01-15 00:00:00',
            'description' => 'The Provo City Center Temple open house was held.',
            'temple_id' => $provoTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Dedication',
            'date' => '2016-03-20 00:00:00',
            'description' => 'The Provo City Center Temple was dedicated.',
            'temple_id' => $provoTemple->id,
        ]);

        $manhattanTemple = Temple::where('name', 'Manhattan New York Temple')->first();
        TempleEvent::create([
            'name' => 'Announcement',
            'date' => '2002-08-07 00:00:00',
            'description' => 'The Manhattan New York Temple was announced.',
            'temple_id' => $manhattanTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Site Dedication',
            'date' => '2002-09-23 00:00:00',
            'description' => 'The groundbreaking ceremony for the Manhattan New York Temple was held.',
            'temple_id' => $manhattanTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Open House',
            'date' => '2004-05-08 00:00:00',
            'description' => 'The Manhattan New York Temple open house was held.',
            'temple_id' => $manhattanTemple->id,
        ]);
        TempleEvent::create([
            'name' => 'Dedication',
            'date' => '2004-06-13 00:00:00',
            'description' => 'The Manhattan New York Temple was dedicated.',
            'temple_id' => $manhattanTemple->id,
        ]);
    }
}
