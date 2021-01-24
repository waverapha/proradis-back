<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};

class PatientController extends Controller
{
    public function __construct(){
        //
    }

    public function index(){
        $data = [
            'data' => Patient::all()
        ];
        
        return response($data);
    }

    public function show(int $id){
        try{
            $patient = Patient::findOrFail($id);

            $data = [
                'data' => $patient
            ];

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

        $patient = Patient::create($request->all());

        $data = [
            'data' => [
                'id' => $patient->id
            ]
        ];

        return response($data, 201);
    }

    public function update(Request $request, int $id){
        try{
            $patient = Patient::findOrFail($id);

            $patient->update($request->all());

            $data = [
                'data' => [
                    'id' => $patient->id,
                    'created_at' => $patient->created_at,
                    'updated_at' => $patient->updated_at
                ]
            ];

            return response($data);

        } catch(ModelNotFoundException $e) {
            return response(null, Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $id){
        try{
            $patient = Patient::findOrFail($id);

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
