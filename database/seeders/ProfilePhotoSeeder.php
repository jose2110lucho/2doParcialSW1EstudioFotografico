<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilePhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('profile_photos')->insert([
            [
                'profile_photo_path' => 'https://res.cloudinary.com/de9nzcfsz/image/upload/v1699670009/cristiano-ronaldo-al-nassr_sprfcl.webp',
                'user_id' => '1',
            ],
            [
                'profile_photo_path' => 'https://res.cloudinary.com/de9nzcfsz/image/upload/v1699670034/download_ddeujz.jpg',
                'user_id' => '2',
            ],
            [
                'profile_photo_path' => 'https://res.cloudinary.com/de9nzcfsz/image/upload/v1699670057/download_slaqfm.jpg',
                'user_id' => '3',
            ],
            [
                'profile_photo_path' => 'https://res.cloudinary.com/de9nzcfsz/image/upload/v1699670083/download_kz3rt0.jpg',
                'user_id' => '4',
            ]

        ]);

    }
}
