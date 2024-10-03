<?php

namespace Database\Seeders;

use App\Models\User;
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
        $users = User::all();

        foreach($users as $user)
        {
            if(!$user->customer_id && $user->department_id)
            {
                $user->update([
                    'customer_id' => $user->department->customer_id
                ]);
            }
        }
    }
}