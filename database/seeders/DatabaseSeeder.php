<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(UserDepartmentSeeder::class);
        // $this->call([IncidentSeeder::class]);

        // Customer::create([
        //     'company_name' => 'Core Data',
        //     'contact_person' => 'Helpdesk',
        //     'email' => 'helpdesk@coredata.com.my',
        //     'phone_number' => '0123456789',
        // ]);

        // // init user
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@coredata.com.my',
        //     'password' => bcrypt('password'),
        //     'role' => 'admin',
        //     'email_verified_at' => now(),
        //     'remember_token' => null,
        //     'customer_id' => 1,
        // ]);

        // seeder to fix the format of the ticket number


        $this->call(IncidentNumberSeeder::class);
    }
}
