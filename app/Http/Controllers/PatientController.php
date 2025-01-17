<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PatientService;
use App\Transformers\PatientTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};

class PatientController extends Controller
{
    public function __construct(PatientService $service){
        $this->service = $service;
    }

    public function index(){
        $patients = $this->service->all(self::$resultsPerPage);

        $data = $this->paginate($patients, new PatientTransformer);
        
        return response($data);
    }

    public function show(int $id){
        try{
            $patient = $this->service->findById($id);

            $data = $this->item($patient, new PatientTransformer);

            return response($data);

        } catch(ModelNotFoundException $e) {
            return response(null, Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request){
        $this->validate($request, Patient::rules());

        $patient = $this->service->store($request->all());

        $data = $this->item($patient, new PatientTransformer);

        return response($data, 201);
    }

    public function update(Request $request, int $id){
        $this->validate($request, Patient::rules());

        try{
            $patient = $this->service->update($id, $request->all());

            return $this->item($patient, new PatientTransformer);

        } catch(ModelNotFoundException $e) {
            return response(null, Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response([
                'message' => 'Um erro ocorreu! Nossa equipe já foi avisada e está verificando.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $id){
        try{
            $this->service->destroy($id);

            return response(null, Response::HTTP_NO_CONTENT);

        } catch(ModelNotFoundException $e) {
            return response(null, Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
