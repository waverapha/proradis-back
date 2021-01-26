<?php

namespace App\Services;

use App\Models\MedicalAppointment;

class MedicalAppointmentService
{
    public function all(int $resultsPerPage){
        return MedicalAppointment::paginate($resultsPerPage);
    }

    public function findById(int $id){
        return MedicalAppointment::findOrFail($id);
    }

    public function store(array $data){
        return MedicalAppointment::create($data);
    }

    public function update(int $id, array $data){
        $medicalAppointment = $this->findById($id);

        $medicalAppointment->update($data);

        return $medicalAppointment;
    }

    public function destroy(int $id){
        $medicalAppointment = $this->findById($id);

        $medicalAppointment->delete();

        return $medicalAppointment;
    }

}