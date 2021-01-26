<?php

namespace App\Http\Controllers;

use App\Models\MedicalAppointment;
use App\Services\MedicalAppointmentService;
use App\Transformers\MedicalAppointmentTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};

class MedicalAppointmentController extends Controller
{
    public function __construct(MedicalAppointmentService $service){
        $this->service = $service;
    }

    public function index(){
        $patients = $this->service->all(self::$resultsPerPage);

        $data = $this->paginate($patients, new MedicalAppointmentTransformer);
        
        return response($data);
    }

    public function show(int $id){
        try{
            $patient = $this->service->findById($id);

            $data = $this->item($patient, new MedicalAppointmentTransformer);

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
        $this->validate($request, MedicalAppointment::rules());

        $patient = $this->service->store($request->all());

        $data = $this->item($patient, new MedicalAppointmentTransformer);

        return response($data, 201);
    }

    public function update(Request $request, int $id){
        $this->validate($request, MedicalAppointment::rules());

        try{
            $patient = $this->service->update($id, $request->all());

            return $this->item($patient, new MedicalAppointmentTransformer);

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
            $patient = $this->service->destroy($id);

            $patient->delete();

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
