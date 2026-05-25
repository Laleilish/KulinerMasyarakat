<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;

class HiddenGemController extends Controller
{
    public function index()
    {
        $kampusList = [
            ['id' => 0, 'name' => 'Universitas Pendidikan Indonesia', 'logo' => 'Upi.png',   'map_embed' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7922.488901693142!2d107.5888298!3d-6.8612798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e73a84ea111d%3A0xcf04fadee4c999a9!2sUpi%20bandung!5e0!3m2!1sen!2sid!4v1775388747856!5m2!1sen!2sid'],
            ['id' => 1, 'name' => 'Institut Teknologi Bandung',       'logo' => 'ITB.png',   'map_embed' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7922.488901693142!2d107.5888298!3d-6.8612798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e73a84ea111d%3A0xcf04fadee4c999a9!2sUpi%20bandung!5e0!3m2!1sen!2sid!4v1775388747856!5m2!1sen!2sid'],
            ['id' => 2, 'name' => 'Universitas Padjajaran',           'logo' => 'Unpad.png', 'map_embed' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7922.488901693142!2d107.5888298!3d-6.8612798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e73a84ea111d%3A0xcf04fadee4c999a9!2sUpi%20bandung!5e0!3m2!1sen!2sid!4v1775388747856!5m2!1sen!2sid'],
            ['id' => 3, 'name' => 'Telkom University',                'logo' => 'Tel-U.png', 'map_embed' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7922.488901693142!2d107.5888298!3d-6.8612798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e73a84ea111d%3A0xcf04fadee4c999a9!2sUpi%20bandung!5e0!3m2!1sen!2sid!4v1775388747856!5m2!1sen!2sid'],
            ['id' => 4, 'name' => 'Universitas Parahyangan',          'logo' => 'Unpar.png', 'map_embed' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7922.488901693142!2d107.5888298!3d-6.8612798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e73a84ea111d%3A0xcf04fadee4c999a9!2sUpi%20bandung!5e0!3m2!1sen!2sid!4v1775388747856!5m2!1sen!2sid'],
        ];

        $selectedKampus = 0;

        $topRatings = Restaurant::latest()->take(5)->get();

        // ← Pastikan nama view-nya benar!
        return view('hidden-gem.index', compact('kampusList', 'selectedKampus', 'topRatings'));
    }
}