<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = \App\Models\User::factory(50)
            ->create()
            ->each(function ($user) {
                $details = \App\Models\UserDetails::factory()->make();
                $details->id = $user->id;
                $user->name = substr($details->firstname, 0, 1) . $details->lastname;
                $user->save();
                $user->details()->save($details);
            });
    }
}
