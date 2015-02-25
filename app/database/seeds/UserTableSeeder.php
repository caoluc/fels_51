<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->truncate();

        $users = [
            [
                'username' => 'caoluc',
                'email' => 'caoluc@mail.com',
                'password' => Hash::make('caolucok'),
                'avatar_url' => 'http://www.gravatar.com/avatar/0d4633d1cf2f8d750adc85ef34f87562.png',
            ],
            [
                'username' => 'User',
                'email' => 'user@mail.com',
                'password' => Hash::make('user'),
            ],
            [
                'username' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin'),
                'role' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
