<?php

namespace App\Transformers;

use App\Models\MedicalAppointment;

class MedicalAppointmentTransformer extends Transformer
{
    protected $availableIncludes = [
        'patient'
    ];

    public function transform($medicalAppointment){
        return [
            'id' => (int)$medicalAppointment->id,
            'record' => $medicalAppointment->record,
            'patient_id' => $medicalAppointment->patient_id,
            'created_at' => $medicalAppointment->created_at,
            'updated_at' => $medicalAppointment->updated_at,
            'deleted_at' => $medicalAppointment->deleted_at
        ];
    }

    public function includePatient(MedicalAppointment $medicalAppointment)
    {
        $patient = $medicalAppointment->patient;

        return $this->item($patient, new PatientTransformer);
    }
}