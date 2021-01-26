<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes,
    Factories\HasFactory
};

class MedicalAppointment extends Model
{
    use HasFactory, SoftDeletes;

    public static function rules(){
        return [
            'content' => 'required|string|max:1000',
        ];
    }
    
    protected $fillable = [
        'content'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
