<?php

namespace Database\Factories;

use App\Models\UserDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $commercial = $this->faker->boolean();

        return [
            'id' => \App\Models\User::factory(),
            'is_commercial' => $commercial,
            'company' => $commercial ? $this->faker->company() : '',
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'street' => $this->faker->streetName(),
            'street_number' => $this->faker->buildingNumber(),
            'zip' => $this->faker->postCode(),
            'city' => $this->faker->city(),
            'industry' => $commercial ? $this->faker->randomElement(['Handwerk', "Dienstleistung", "Gesundheit", "Technik", "Sonstiges", "Metall", "Kunststoff", "Feinmechanik", "Konstruktion"]) : null,
            'homepage' => $this->faker->url(),
            'tel' => $this->faker->phoneNumber(),
            'paypal_user' => $this->faker->safeEmail(),
        ];
    }
}
