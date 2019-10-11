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

        $user = factory(App\User::class)->create([
            'admin' => true,
            'email' => 'admin@gmail.com'
        ]);

        $user = factory(App\User::class)->create();

        $user = factory(App\User::class)->create([
            'subscribed' => true
        ]);

        $user = factory(App\User::class)->create([
            'subscribed' => true,
            'deleted_at' => Carbon::now()
        ]);

        $user = factory(App\User::class)->create([
            'subscribed' => true,
            'required_reactivation' => true
        ]);

        // $user = factory(App\User::class, 50)->create();

    }
}
