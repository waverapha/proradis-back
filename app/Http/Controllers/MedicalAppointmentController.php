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

    public function index(int $patient){
        $medicalAppointments = $this->service->all(self::$resultsPerPage, $patient);

        $data = $this->paginate($medicalAppointments, new MedicalAppointmentTransformer);
        
        return response($data);
    }

    public function show(int $patient, int $id){
        try{
            $medicalAppointment = $this->service->findByIdInPatient($patient, $id);

            $data = $this->item($medicalAppointment, new MedicalAppointmentTransformer);

            return response($data);

        } catch(ModelNotFoundException $e) {
            return response(null, Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request, int $patient){
        $this->validate($request, MedicalAppointment::rules());

        $medicalAppointment = $this->service->store($patient, $request->all());

        $data = $this->item($medicalAppointment, new MedicalAppointmentTransformer);

        return response($data, 201);
    }

    public function update(Request $request, int $patient, int $id){
        $this->validate($request, MedicalAppointment::rules());

        try{
            $patient = $this->service->update($patient, $id, $request->all());

            return $this->item($patient, new MedicalAppointmentTransformer);

        } catch(ModelNotFoundException $e) {
            return response(null, Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response([
                'message' => 'Um erro ocorreu! Nossa equipe já foi avisada e está verificando.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $patient, int $id){
        try{
            $patient = $this->service->destroy($patient, $id);

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
