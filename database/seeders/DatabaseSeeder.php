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
        // Initialize Admin Account
        if(!User::where('email', 'admin@coredata.com.my')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@coredata.com.my',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }
        
        $this->call(AssetSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
