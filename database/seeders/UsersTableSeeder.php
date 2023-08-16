<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
        'name' => 'Sergio',
            'email' => 'sergio@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'cedula' => '177672300',
            'address' => 'Av. Santiago',
            'phone' => '933927031',
            'role' => 'admin',

       ]);

       User::factory()
       ->count(50)
       ->create();


    }
}
