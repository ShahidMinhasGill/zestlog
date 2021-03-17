<?php

use Illuminate\Database\Seeder;
use App\Models\Plan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name'        => 'Ari',
                'last_name'         => 'Ari',
                'user_name'         => 'ari_admin',
                'user_type'         => '1',
                'status'            => '1',
                'specialization_id'    => '2',
                'title'             => 'Nutrition',
                'is_verify'             => '1',
                'last_login'        => now(),
                'email'             => 'ari@admin.com',
                'password'          => \Hash::make('demo123'),
                'mobile_number'     => '9999999999',
                'extension'         => '47',
                'updated_at'        => now(),
                'created_at'        => now(),
            ]
        ]);
        DB::table('users')->insert([
            [
                'first_name'        => 'Ari',
                'last_name'         => 'Ari',
                'user_name'         => 'ari_coach',
                'user_type'         => '0',
                'status'            => '1',
                'specialization_id'    => '2',
                'title'             => 'Nutrition',
                'is_coach_channel'  => '1',
                'is_verify'             => '1',
                'last_login'        => now(),
                'email'             => 'ari@admin.com',
                'password'          => \Hash::make('demo123'),
                'mobile_number'     => '3001010100',
                'extension'         => '92',
                'updated_at'        => now(),
                'created_at'        => now(),
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'code' => 'GBP',
                'symbol' => '£',
                'name' => 'Pound sterling',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ]);
    }
}
