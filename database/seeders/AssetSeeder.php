<?php

namespace Database\Seeders;

use App\Helper\AssetHelper;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $assets = Asset::all();

        foreach($assets as $asset)
        {
            if(!$asset->asset_number)
            {
                $asset->asset_number = AssetHelper::generateAssetNumber($asset);
                $asset->save();
            }
        }
    }
}
