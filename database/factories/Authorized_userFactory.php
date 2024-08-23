<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Authorized_user>
 */
class Authorized_userFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Authorized_user::class;

    public function definition(): array
    {
        return [
            'fname' => $this->faker->firstName, // Random first name
            'lname' => $this->faker->lastName, // Random last name
            'mname' => $this->faker->firstName, // Random middle name
            'contact_no' => $this->faker->phoneNumber, // Random phone number
            'user_type' => $this->faker->randomElement([1, 2, 3]), // Random user type (assuming 1, 2, 3 as possible types)
            'emp_id' => '2024-' . $this->faker->numerify('###-####'), // Example: 2024-123-4567
            'created_at' => now(), // Current timestamp
            'updated_at' => now(), // Current timestamp
        ];
    }
}
