<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Campus;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        $campuses = Campus::all();

        if (!$user || $campuses->isEmpty()) {
            return;
        }

        $restaurants = [
            [
                'user_id' => $user->id,
                'campus_id' => $campuses->where('name', 'Universitas Pendidikan Indonesia')->first()?->id ?? $campuses->first()->id,
                'name' => 'Ayam Geprek UPI Mantap',
                'category' => 'makanan_berat',
                'is_featured' => true,
                'food_type' => 'Ayam Geprek',
                'image' => 'restaurants/placeholder.jpg',
                'description' => 'Ayam geprek super pedas dengan berbagai pilihan level cabai, sangat populer di kalangan mahasiswa UPI.',
                'address' => 'Jl. Dr. Setiabudi No.229, Sukasari, Bandung',
                'open_hours' => '10:00 - 21:00',
                'price_range' => 'Rp 15.000 - Rp 25.000',
                'gmaps_link' => 'https://maps.google.com',
                'latitude' => -6.8612,
                'longitude' => 107.5888,
                'landmark' => 'Gerbang Utama UPI',
                'landmark_photo' => null,
                'status' => 'approved',
                'rating' => 4.5,
            ],
            [
                'user_id' => $user->id,
                'campus_id' => $campuses->where('name', 'Institut Teknologi Bandung')->first()?->id ?? $campuses->first()->id,
                'name' => 'Nasi Goreng Ganesha ITB',
                'category' => 'makanan_berat',
                'food_type' => 'Nasi Goreng',
                'image' => 'restaurants/placeholder.jpg',
                'description' => 'Nasi goreng legendaris dengan porsi melimpah dan aroma khas arang tungku.',
                'address' => 'Jl. Ganesha No.10, Lb. Siliwangi, Coblong, Bandung',
                'open_hours' => '17:00 - 23:00',
                'price_range' => 'Rp 18.000 - Rp 30.000',
                'gmaps_link' => 'https://maps.google.com',
                'latitude' => -6.8944,
                'longitude' => 107.6106,
                'landmark' => 'Kantin Masjid Salman ITB',
                'landmark_photo' => null,
                'status' => 'approved',
                'rating' => 4.8,
            ],
            [
                'user_id' => $user->id,
                'campus_id' => $campuses->where('name', 'Universitas Padjajaran')->first()?->id ?? $campuses->first()->id,
                'name' => 'Sate Jatinangor Unpad',
                'category' => 'makanan_berat',
                'food_type' => 'Sate Ayam',
                'image' => 'restaurants/placeholder.jpg',
                'description' => 'Sate ayam bumbu kacang kental khas Madura, dagingnya tebal dan empuk.',
                'address' => 'Jl. Raya Bandung Sumedang KM.21, Jatinangor',
                'open_hours' => '16:00 - 22:00',
                'price_range' => 'Rp 20.000 - Rp 35.000',
                'gmaps_link' => 'https://maps.google.com',
                'latitude' => -6.9218,
                'longitude' => 107.7697,
                'landmark' => 'Dekat Gerbang Unpad Jatinangor',
                'landmark_photo' => null,
                'status' => 'approved',
                'rating' => 4.2,
            ],
            [
                'user_id' => $user->id,
                'campus_id' => $campuses->where('name', 'Telkom University')->first()?->id ?? $campuses->first()->id,
                'name' => 'Warkop Cozy Tel-U',
                'category' => 'minuman',
                'food_type' => 'Kopi & Indomie',
                'image' => 'restaurants/placeholder.jpg',
                'description' => 'Tempat nongkrong asyik dengan wifi cepat, menyediakan aneka kopi, mie instan kekinian, dan jajanan ringan.',
                'address' => 'Jl. Telekomunikasi No.1, Terusan Buah Batu, Bandung',
                'open_hours' => '24 Jam',
                'price_range' => 'Rp 5.000 - Rp 20.000',
                'gmaps_link' => 'https://maps.google.com',
                'latitude' => -6.9732,
                'longitude' => 107.6301,
                'landmark' => 'Gedung Tokong Nanas',
                'landmark_photo' => null,
                'status' => 'approved',
                'rating' => 4.0,
            ],
            [
                'user_id' => $user->id,
                'campus_id' => $campuses->where('name', 'Universitas Parahyangan')->first()?->id ?? $campuses->first()->id,
                'name' => 'Batagor Ciumbuleuit Unpar',
                'category' => 'jajanan',
                'food_type' => 'Batagor',
                'image' => 'restaurants/placeholder.jpg',
                'description' => 'Batagor renyah dengan rasa tenggiri premium dan saus kacang gurih pedas manis.',
                'address' => 'Jl. Ciumbuleuit No.94, Hegarmanah, Cidadap, Bandung',
                'open_hours' => '09:00 - 18:00',
                'price_range' => 'Rp 10.000 - Rp 20.000',
                'gmaps_link' => 'https://maps.google.com',
                'latitude' => -6.8746,
                'longitude' => 107.6075,
                'landmark' => 'Seberang Kampus Unpar',
                'landmark_photo' => null,
                'status' => 'approved',
                'rating' => 4.7,
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
