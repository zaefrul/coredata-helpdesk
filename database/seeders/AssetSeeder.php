<?php

namespace Database\Seeders;

use App\Models\Asset;
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
        $assets = Asset::all();

        foreach($assets as $asset)
        {
            if(!$asset->asset_number)
            {
                $asset->asset_number = 'ASSET-' . str_pad($asset->id, 5, '0', STR_PAD_LEFT);
                $asset->save();
            }
        }
    }
}
