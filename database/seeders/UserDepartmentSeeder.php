<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get department details and create user based on department information

        $departments = Department::all();

        foreach($departments as $department) {
            try
            {
                if($department->pc_email == null)
                {
                    throw new \Exception('No email address for department');
                }

                if(User::where('email', $department->pc_email)->exists())
                {
                    throw new \Exception('User already exists');
                }

                User::create([
                    'name' => $department->pc_name,
                    'email' => $department->pc_email,
                    'password' => bcrypt('password'),
                    'role' => 'user',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'phone_number' => $department->pc_phone,
                    'customer_id' => $department->customer_id,
                    'department_id' => $department->id,
                ]);
            }
            catch(\Exception $e)
            {
                Log::error('Error creating user for department: ' . $e->getMessage());
                Log::info(print_r($department, true));
                continue;
            }
        }
    }
}