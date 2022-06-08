<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return $this->faker->boolean
            ? [
                'description' => 'E-mail',
                'contact' => $this->faker->email,
                'person_id' => \App\Models\Person::factory(),
            ] : [
                'description' => 'Celular',
                'contact' => $this->faker->phoneNumberCleared,
                'person_id' => \App\Models\Person::factory(),
            ];
    }
}
