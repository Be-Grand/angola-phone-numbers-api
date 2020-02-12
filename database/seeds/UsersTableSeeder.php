<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = ([
            [
            'first_name' => 'Ravelino',
            'last_name' => 'de Castro',
            'birth_date' => Carbon:: now()-> format('Y-m-d'),
            'gender'=> '1',
            'email' => 'ravelinodecastro@begrand.tech',
            'phone' => '927562797',
            'address' => 'Luanda, Angola',
            'password' => Hash::make('admin123'),
            'status' => '0',
            'type' => '0',
            'created_at' =>Carbon:: now()-> format('Y-m-d H:i:s'),
            'updated_at' =>Carbon:: now()-> format('Y-m-d H:i:s'),
            ],
        ]);
        User::insert($users);
    }
}