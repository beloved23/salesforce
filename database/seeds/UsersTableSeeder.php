<?php

use Illuminate\Database\Seeder;
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
        DB::table('users')->insert([
            'auuid' => '123123',
            'email' => 'sleekpetals.com@gmail.com',
            'password' => '$2y$10$vuqFjLOAINbZKu6O6iNnY.rJ3bp7BzaZFKrVwX7sYAE/co4VeH/qe',
            'remember_token'=>Hash::make('123123'),
            'last_login_date'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'created_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'updated_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
        ]);
        DB::table('users')->insert([
            'id' => '101101',
            'email' => 'airtel@gmail.com',
            'password' => '$2y$10$afSqYPQtNCTdi/7Uz0BKgupiYC.avU0frhDBK/OYsU46HdL0f2LyS',
            'remember_token'=>Hash::make('101101'),
            'last_login_date'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'created_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'updated_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
        ]);
        DB::table('users')->insert([
            'id' => '234789',
            'email' => 'airtel2@gmail.com',
            'password' => '$2y$10$hEDgzwW9rMD5gsy2dEcFxOjV1U1y9k3tpLvaz4BUs2ECx8WVIC8oK',
            'remember_token'=>Hash::make('234789'),
            'last_login_date'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'created_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'updated_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
        ]);
        DB::table('users')->insert([
            'id' => '230334',
            'email' => 'airte66@gmail.com',
            'password' => '$2y$10$GiVcpLji/XHI8OkvmX7xlOU3SQS6mg8AAkP3vcGbc2v3fu2VtxQgW',
            'remember_token'=>Hash::make('230334'),
            'last_login_date'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'created_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
            'updated_at'=>Carbon::now('Africa/Lagos')->toDateTimeString(),
        ]);
    }
}
