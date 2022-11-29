<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\UserDetails::factory()->count(50)->make();

        foreach ($users as $user) {
            $user->user->name = substr($user->firstname, 0, 1) . $user->lastname;
            $user->user->save();
            $user->save();
        }
    }
}
