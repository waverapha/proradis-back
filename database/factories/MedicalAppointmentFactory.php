<?php

namespace Database\Factories;

use App\Models\MedicalAppointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalAppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MedicalAppointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'record' => $this->faker->text,
        ];
    }
}
