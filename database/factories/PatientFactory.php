<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = "{$this->faker->firstName()} {$this->faker->lastName()}";

        return [
            'name' => $name,
            'birthdate' => $this->faker->date('d/m/Y'),
            'gender' => $this->faker->randomElement(Patient::$genders),
            'document' => $this->faker->unique()->cpf(false)
        ];
    }
}
