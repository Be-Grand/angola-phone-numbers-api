<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Phone;
use Carbon\Carbon;
class PhonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $phones = ([
            [
                'number' => '927562797',
                'operator_id' => '1',
                'customer_id' => '1',
                'status' => '1',
                'created_at' =>Carbon:: now()-> format('Y-m-d H:i:s'),
                'updated_at' =>Carbon:: now()-> format('Y-m-d H:i:s'),
            ],
        ]);
        Phone::insert($phones);
    }
}