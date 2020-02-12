<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Carbon\Carbon;
class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Customer::create([
            'name' => 'Ravelino de Castro',
            'birth_date' => '1999-05-03',
            'gender'=> '0',
            'bi'=> '004758993LA045',
            'nif'=> '004758993LA045',
            'passport'=> 'N2044977',
            'email' => 'ravelinodecastro@gmail.com',
            'address' => 'Luanda, Angola',
            'created_at' =>Carbon:: now()-> format('Y-m-d H:i:s'),
            'updated_at' =>Carbon:: now()-> format('Y-m-d H:i:s'),
        ]);
    }
}