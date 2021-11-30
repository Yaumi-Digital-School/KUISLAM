<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'username' => 'admin123',
                'password' => bcrypt('12345678'),
                'avatar' => 'admin.jpg',
                'role' => 'admin',
            ],
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'username' => 'user1234',
                'password' => bcrypt('12345678'),
                'avatar' => 'user.jpg',
                'role' => 'user',
            ],
            [
                'name' => 'adit',
                'email' => 'adit@adit.com',
                'username' => 'adit1234',
                'password' => bcrypt('12345678'),
                'avatar' => 'adit.jpg',
                'role' => 'user',
            ],
            [
                'name' => 'erki',
                'email' => 'erki@erki.com',
                'username' => 'erki1234',
                'password' => bcrypt('12345678'),
                'avatar' => 'erki.jpg',
                'role' => 'user',
            ]
            ];
            foreach ($user as $key => $value) {
                User::insert($value);
            }
    }
}
