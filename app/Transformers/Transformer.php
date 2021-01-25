<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

abstract class Transformer extends TransformerAbstract
{   
    public $type = 'unknown';

    protected $fields;
    
    abstract public function transform(Model $model);
}