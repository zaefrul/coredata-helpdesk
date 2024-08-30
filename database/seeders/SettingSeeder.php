<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $componentTypes = ['Hard Disk', 'Memory', 'Storage', 'Switch', 'PCIE', 'Power Supply', 'System Board'];
        $componentValues = ['hard_disk', 'memory', 'storage', 'switch', 'pcie', 'power_supply', 'system_board'];

        foreach ($componentTypes as $key=>$type) {
            Setting::create([
                'field' => 'component_type',
                'value' => $componentValues[$key],
                'label' => $type
            ]);
        }
    }
}
