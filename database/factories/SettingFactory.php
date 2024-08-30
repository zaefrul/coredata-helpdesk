<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key' => 'component_type',
            'label' => $this->faker->randomElement([
                'Hard Disk', 'Memory', 'Storage', 'Switch', 'PCIE', 'Power Supply', 'System Board'
            ]),
            'value' => $this->faker->randomElement([
                'hard_disk', 'memory', 'storage', 'switch', 'pcie', 'power_supply', 'system_board'
            ]),
        ];
    }
}
