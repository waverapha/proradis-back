<?php

namespace App\Transformers;

class MedicalAppointmentTransformer extends Transformer
{
    public function transform($patient){
        return [
            'id' => (int)$patient->id,
            'content' => $patient->name,
            'created_at' => $patient->created_at,
            'updated_at' => $patient->updated_at,
            'deleted_at' => $patient->deleted_at
        ];
    }
}