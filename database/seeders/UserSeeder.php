<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@outlook.com';
        $user->password =  Hash::make('admin');
        $user->save();
        //$user->roles()->attach(Role::where('name', 'admin')->first());
    }
}
