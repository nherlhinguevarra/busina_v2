<?php

namespace Database\Factories;

use App\Models\Vehicle_owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Vehicle::class;

    public function definition(): array
    {
        return [
            'vehicle_owner_id' => Vehicle_owner::factory(), // Assuming VehicleOwner model and factory exist
            'model_color' => $this->faker->safeColorName, // Random color name
            'plate_no' => strtoupper($this->faker->bothify('???-####')), // Example: ABC-1234
            'expiry_date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'), // Expiry date within the next 2 years
            // 'copy_driver_license' => $generateBinaryData(), // Binary data for the driver's license copy
            // 'copy_cor' => $generateBinaryData(), // Binary data for the COR copy
            // 'copy_school_id' => $generateBinaryData(), // Binary data for the school ID copy
            // 'vehicle_type_id' => VehicleType::factory(), // Assuming VehicleType model and factory exist
            // 'or_no' => strtoupper($this->faker->bothify('OR-#######')), // Example: OR-1234567
            // 'cr_no' => strtoupper($this->faker->bothify('CR-#######')), // Example: CR-1234567
            // 'copy_or_cr' => $generateBinaryData(), // Binary data for the OR/CR copy
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
