<?php

namespace App\Services;

use App\Models\{Patient, MedicalAppointment};

class MedicalAppointmentService
{
    public function all(int $resultsPerPage, int $patient = null){
        if( is_null($patient) ){
            return MedicalAppointment::paginate($resultsPerPage);
        }

        return Patient::findOrFail($patient)
        ->medicalAppointments()
        ->paginate($resultsPerPage);
    }

    public function findById(int $id, int $patient = null){
        if( is_null($patient) ){
            return MedicalAppointment::findOrFail($id);
        }

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
        $medicalAppointment = $this->findById($id, $patient);

        $medicalAppointment->update($data);

        return $medicalAppointment;
    }

    public function destroy(int $patient, int $id){
        $medicalAppointment = $this->findById($id, $patient);

        $medicalAppointment->delete();

        return $medicalAppointment;
    }

}