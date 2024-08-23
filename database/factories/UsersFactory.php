<?php

namespace Database\Factories;

use App\Models\Authorized_user;
use App\Models\Users;
use App\Models\Vehicle_owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Users::class;

    public function definition(): array
    {
        return [
            // 'authorzied_user_id' => Authorized_user::factory(),
            // 'vehicle_owner_id'=> Vehicle_owner::factory(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at'=> now(),
        ];
    }
}
