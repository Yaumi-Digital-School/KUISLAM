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
            ]
            ];
            foreach ($user as $key => $value) {
                User::insert($value);
            }
    }
}
