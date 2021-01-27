<?php

namespace App\Transformers;

use App\Models\Patient;

class PatientTransformer extends Transformer
{
    protected $availableIncludes = [
        'medicalAppointments'
    ];

    public function transform($patient){
        return [
            'id' => (int)$patient->id,
            'name' => $patient->name,
            'birthdate' => $patient->birthdate,
            'gender' => $patient->gender,
            'document' => $patient->document,
            'created_at' => $patient->created_at,
            'updated_at' => $patient->updated_at,
            'deleted_at' => $patient->deleted_at
        ];
    }

    public function includeMedicalAppointments(Patient $patient)
    {
        $medicalAppointments = $patient->medicalAppointments;

        return $this->collection($medicalAppointments, new MedicalAppointmentTransformer);
    }
}