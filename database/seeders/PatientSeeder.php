<?php

namespace Database\Seeders;

use App\Models\MedicalAppointment;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patient::factory()
        ->count(25)
        ->create()
        ->each(function($patient){
            $random = random_int(1, 3);

            $medicalAppointments = MedicalAppointment::factory()->count($random)->make();

            $patient->medicalAppointments()->saveMany($medicalAppointments);
        });
    }
}
