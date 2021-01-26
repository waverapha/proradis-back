<?php

namespace App\Services;

use App\Models\MedicalAppointment;
use App\Models\Patient;

class MedicalAppointmentService
{
    public function all(int $resultsPerPage, int $patient){
        return Patient::findOrFail($patient)
        ->medicalAppointments()
        ->paginate($resultsPerPage);
    }

    public function findById(int $id){
        return MedicalAppointment::findOrFail($id);
    }

    public function findByIdInPatient(int $patient, int $id){
        return Patient::findOrFail($patient)
        ->medicalAppointments()
        ->findOrFail($id);
    }

    public function store(int $patient, array $data){
        $patient = Patient::findOrFail($patient)
        ->medicalAppointments()
        ->create($data);

        return $patient;
    }

    public function update(int $patient, int $id, array $data){
        $medicalAppointment = $this->findByIdInPatient($patient, $id);

        $medicalAppointment->update($data);

        return $medicalAppointment;
    }

    public function destroy(int $patient, int $id){
        $medicalAppointment = $this->findByIdInPatient($patient, $id);

        $medicalAppointment->delete();

        return $medicalAppointment;
    }

}