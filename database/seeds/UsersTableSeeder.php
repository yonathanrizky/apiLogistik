<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Joni',
            'identity_id' => '12',
            'gender' => 1,
            'address' => 'Tangerang',
            'photo' => 'jon.png', //note: tidak ada gambar
            'email' => 'jon@yonathanrizky.com',
            'password' => app('hash')->make('apaanpasswordnya?'),
            'phone_number' => '08568490753',
            'api_token' => Str::random(40),
            'role' => 0,
            'status' => 1
        ]);
    }
}
