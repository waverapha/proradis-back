<?php

namespace App\Transformers;

class PatientTransformer extends Transformer
{
    public function transform($patient){
        return [
            'id' => (int)$patient->id,
            'name' => $patient->name,
            'birthdate' => $patient->birthdate,
            'gender' => $patient->genre,
            'document' => $patient->document,
            'created_at' => $patient->created_at,
            'updated_at' => $patient->updated_at,
            'deleted_at' => $patient->deleted_at
        ];
    }
}