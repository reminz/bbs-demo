<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $users = factory(App\Models\User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
    }
}