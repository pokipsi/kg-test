<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('password'),
            'admin' => true
        ]);

        DB::table('users')->insert([
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('password')
        ]);

        DB::table('users')->insert([
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('password'),
            'subscribed' => true,
            'order_id'=>'1234567'
        ]);

        DB::table('users')->insert([
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('password'),
            'subscribed' => true,
            'order_id'=>'1234567',
            'deleted_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('password'),
            'subscribed' => true,
            'order_id'=>'1234567',
            'required_reactivation' => true
        ]);
    }
}
