<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes,
    Factories\HasFactory
};

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    public static $genders = [
        'M',
        'F',
        'T',
        'O'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'birthdate',
        'gender',
        'document'
    ];
}
