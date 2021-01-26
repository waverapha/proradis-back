<?php

namespace Database\Seeders;

use App\Models\MedicalAppointment;
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
        MedicalAppointment::factory()->make();
    }
}
