<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->truncate();

        $users = [
            [
                'username' => 'User',
                'email' => 'user@mail.com',
                'password' => Hash::make('user')
            ],
            [
                'username' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin'),
                'role' => 1
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }
    }

}
