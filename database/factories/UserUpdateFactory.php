<?php

namespace Database\Factories;

use App\Models\UserUpdate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserUpdate>
 */
class UserUpdateFactory extends Factory
{
    protected $model = UserUpdate::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'time_zone' => $this->faker->timezone(),
        ];
    }
}
