<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $users = [
            [
                'name'           => 'admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('admin'),
                'remember_token' => null,
                'role' => 'Licence',
            ],
        ];

        User::insert($users);
    }
}
