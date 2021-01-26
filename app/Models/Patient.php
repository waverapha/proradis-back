<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes,
    Factories\HasFactory
};

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'birthdate' => 'date:d/m/Y'
    ];

    public static function rules(){
        $genders = implode(',', self::$genders);

        return [
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date_format:d/m/Y',
            'gender' => "required|string|in:{$genders}",
            'document' => 'required|string|cpf|unique:patients,document',
        ];
    }

    public static $genders = [
        'M',
        'F',
        'T',
        'O'
    ];
    
    protected $fillable = [
        'name',
        'birthdate',
        'gender',
        'document'
    ];

    public function setBirthdateAttribute(string $birthdate){
        $this->attributes['birthdate'] = Carbon::createFromFormat('d/m/Y', $birthdate);
    }
}
