<?php

namespace Database\Factories;

use App\Models\Applicant_type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle_owner>
 */
class Vehicle_ownerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Vehicle_owner::class;

    public function definition(): array
    {   
        return [
        'fname' => $this->faker->firstName,
        'lname' => $this->faker->lastName,
        'mname' => $this->faker->firstName,
        'contact_no' => $this->faker->phoneNumber,
        // 'applicant_type_id' => Applicant_type::factory(),
        'qr_code' => Str::random(10),
        'emp_id' => '2024-' . $this->faker->numerify('###-####'),
        'std_id' => '2024-' . $this->faker->numerify('###-####'),
        'driver_license_no' => strtoupper(Str::random(12)),
        'created_at' => now(),
        'updated_at' => now(),
        ];
    }
}
