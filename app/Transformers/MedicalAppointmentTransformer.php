<?php

namespace App\Transformers;

class MedicalAppointmentTransformer extends Transformer
{
    public function transform($medicalAppointment){
        return [
            'id' => (int)$medicalAppointment->id,
            'record' => $medicalAppointment->record,
            'created_at' => $medicalAppointment->created_at,
            'updated_at' => $medicalAppointment->updated_at,
            'deleted_at' => $medicalAppointment->deleted_at
        ];
    }
}