<?php

namespace App\Services;

use App\Models\Patient;

class PatientService
{
    public function all($resultsPerPage){

        return Patient::paginate($resultsPerPage);
    }

    public function findById(int $id){
        return Patient::findOrFail($id);
    }

    public function store(array $data){
        return Patient::create($data);
    }

    public function update(int $id, array $data){
        $patient = $this->findById($id);

        $patient->update($data);

        return $patient;
    }

    public function destroy(int $id){
        $patient = $this->findById($id);

        $patient->delete();

        return $patient;
    }

}