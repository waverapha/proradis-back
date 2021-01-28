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
            'record' => 'required|string|max:1000',
        ];
    }
    
    protected $fillable = [
        'record'
    ];

    protected static function boot(){
        parent::boot();

        static::addGlobalScope('order', function($builder){
            $builder->orderBy('updated_at', 'desc');
        });
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
