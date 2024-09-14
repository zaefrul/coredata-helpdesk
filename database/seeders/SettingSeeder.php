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
            
            if(Setting::where('field', 'component_type')->where('value', $componentValues[$key])->exists()) {
                continue;
            }

            Setting::create([
                'field' => 'component_type',
                'value' => $componentValues[$key],
                'label' => $type
            ]);
        }

        // email settings
        if(!Setting::where('field', 'email_service')->where('label', 'switch')->exists()) {
            Setting::create([
                'field' => 'email_service',
                'value' => 'off',
                'label' => 'switch'
            ]);
        }
    }
}
