<?php

namespace App\Http\Controllers;

use App\Transformers\Transformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use League\Fractal\{
    Manager,
    Pagination\IlluminatePaginatorAdapter,
    Resource\Collection,
    Resource\Item
};

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected static $resultsPerPage = 25;

    private function getFractalManager()
    {
        $manager = new Manager();

        if (isset($_GET['include'])) {
            $manager->parseIncludes($_GET['include']);
        }

        return $manager;
    }

    public function item($data, Transformer $transformer)
    {
        $manager = $this->getFractalManager();

        $resource = new Item($data, $transformer, $transformer->type);

        return $manager->createData($resource)->toArray();
    }

    public function collection($data, Transformer $transformer)
    {
        $manager = $this->getFractalManager();

        $resource = new Collection($data, $transformer, $transformer->type);

        return $manager->createData($resource)->toArray();
    }
    
    public function paginate(LengthAwarePaginator $data, Transformer $transformer)
    {
        $manager = $this->getFractalManager();
        
        $resource = new Collection($data, $transformer, $transformer->type);
        
        $resource->setPaginator(new IlluminatePaginatorAdapter($data));
        
        return $manager->createData($resource)->toArray();
    }
}
