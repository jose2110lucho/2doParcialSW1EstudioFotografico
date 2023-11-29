<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('users')->insert([
            [
                'name' => 'Cristiano Ronaldo',
                'email' => 'elbicho@gmail.com',
                'password' => Hash::make('111')
            ],
            [
                'name' => 'Ronlado Asis Moreira',
                'email' => 'ronaldinho@gmail.com',
                'password' => Hash::make('111')
            ],
            [
                'name' => 'Leonel Messi',
                'email' => 'messi@gmail.com',
                'password' => Hash::make('111')
            ],
            [
                'name' => 'Zaltan Ibrahimovich',
                'email' => 'Ibra@gmail.com',
                'password' => Hash::make('111')
            ]

        ]);
        
    }
}
