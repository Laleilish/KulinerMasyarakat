<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campus;

class CampusSeeder extends Seeder
{
    public function run(): void
    {
        $campuses = [
            ['name' => 'Universitas Pendidikan Indonesia', 'logo' => 'Upi.png',   'latitude' => -6.8612798, 'longitude' => 107.5888298, 'map_zoom' => 16],
            ['name' => 'Institut Teknologi Bandung',       'logo' => 'ITB.png',   'latitude' => -6.8944825, 'longitude' => 107.6106498, 'map_zoom' => 16],
            ['name' => 'Universitas Padjajaran',           'logo' => 'Unpad.png', 'latitude' => -6.9218269, 'longitude' => 107.7697928, 'map_zoom' => 15],
            ['name' => 'Telkom University',                'logo' => 'Tel-U.png', 'latitude' => -6.9732558, 'longitude' => 107.6301463, 'map_zoom' => 16],
            ['name' => 'Universitas Parahyangan',          'logo' => 'Unpar.png', 'latitude' => -6.8746802, 'longitude' => 107.6075437, 'map_zoom' => 16],
            ['name' => 'UPI Cibiru',                       'logo' => 'Upi.png',   'latitude' => -6.9398533, 'longitude' => 107.7245773, 'map_zoom' => 16],
        ];

        foreach ($campuses as $campus) {
            Campus::create($campus);
        }
    }
}