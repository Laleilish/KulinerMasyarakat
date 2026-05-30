<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
<<<<<<< HEAD
=======
use App\Models\User;
use App\Models\Campus;
>>>>>>> dev

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        $restaurants = [
            // UPI (campus_id: 1)
            ['campus_id' => 1, 'name' => 'Warung Sunda Cipadung',    'image' => 'image 2.png',  'description' => 'Warung sunda dengan harga mahasiswa, porsi jumbo.',   'latitude' => -6.8603, 'longitude' => 107.5901, 'rating' => 4.8, 'distance' => '0.3km', 'price_range' => 'Rp 10.000 – 20.000', 'category' => 'Sunda', 'is_featured' => true],
            ['campus_id' => 1, 'name' => 'Mie Ayam Pak Kumis',       'image' => 'image 3.png',  'description' => 'Mie ayam legendaris sejak 1995, kuah gurih.',          'latitude' => -6.8621, 'longitude' => 107.5912, 'rating' => 4.6, 'distance' => '0.5km', 'price_range' => 'Rp 12.000 – 18.000', 'category' => 'Mie'],
            ['campus_id' => 1, 'name' => 'Nasi Goreng Bang Jali',    'image' => 'image 6.png',  'description' => 'Nasi goreng spesial dengan telur mata sapi.',          'latitude' => -6.8598, 'longitude' => 107.5878, 'rating' => 4.5, 'distance' => '0.7km', 'price_range' => 'Rp 13.000 – 22.000', 'category' => 'Nasi'],
            ['campus_id' => 1, 'name' => 'Pecel Lele Bu Sari',       'image' => 'image 4.png',  'description' => 'Pecel lele crispy dengan sambal pedas segar.',         'latitude' => -6.8634, 'longitude' => 107.5895, 'rating' => 4.7, 'distance' => '0.4km', 'price_range' => 'Rp 15.000 – 25.000', 'category' => 'Lauk'],
            ['campus_id' => 1, 'name' => 'Bakso Malang Mas Bro',     'image' => 'image 10.png', 'description' => 'Bakso urat kenyal dengan kuah bening segar.',          'latitude' => -6.8645, 'longitude' => 107.5905, 'rating' => 4.4, 'distance' => '0.6km', 'price_range' => 'Rp 12.000 – 20.000', 'category' => 'Bakso'],
            // ITB (campus_id: 2)
            ['campus_id' => 2, 'name' => 'Warung Teknik Sipil',      'image' => 'image 2.png',  'description' => 'Warung legendaris dekat Teknik Sipil ITB.',            'latitude' => -6.8935, 'longitude' => 107.6115, 'rating' => 4.7, 'distance' => '0.2km', 'price_range' => 'Rp 10.000 – 25.000', 'category' => 'Sunda'],
            ['campus_id' => 2, 'name' => 'Kantin Saraga ITB',        'image' => 'image 3.png',  'description' => 'Kantin dengan berbagai menu pilihan mahasiswa.',        'latitude' => -6.8952, 'longitude' => 107.6098, 'rating' => 4.3, 'distance' => '0.1km', 'price_range' => 'Rp 8.000 – 18.000',  'category' => 'Nasi'],
            ['campus_id' => 2, 'name' => 'Mie Reman Ganesha',        'image' => 'image 6.png',  'description' => 'Mie ramen ala Jepang dengan harga lokal.',             'latitude' => -6.8961, 'longitude' => 107.6122, 'rating' => 4.5, 'distance' => '0.4km', 'price_range' => 'Rp 20.000 – 35.000', 'category' => 'Mie'],
            ['campus_id' => 2, 'name' => 'Geprek Mas Tio',           'image' => 'image 4.png',  'description' => 'Ayam geprek super crispy level 1-10.',                 'latitude' => -6.8944, 'longitude' => 107.6088, 'rating' => 4.6, 'distance' => '0.3km', 'price_range' => 'Rp 15.000 – 28.000', 'category' => 'Ayam'],
            ['campus_id' => 2, 'name' => 'Kopi Taman Ganesha',       'image' => 'image 10.png', 'description' => 'Kopi susu hits mahasiswa ITB.',                        'latitude' => -6.8928, 'longitude' => 107.6110, 'rating' => 4.8, 'distance' => '0.5km', 'price_range' => 'Rp 10.000 – 22.000', 'category' => 'Minuman'],
        ];

        foreach ($restaurants as $r) {
            Restaurant::create($r);
        }
    }
}
=======
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
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
>>>>>>> dev
