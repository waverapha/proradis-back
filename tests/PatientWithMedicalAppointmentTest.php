<?php

use App\Models\MedicalAppointment;
use App\Models\Patient;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\{
    DatabaseMigrations,
    DatabaseTransactions
};

class PatientWithMedicalAppointmentTest extends TestCase
{
    use DatabaseTransactions;

    private $table = 'medical_appointments';

    public function getTestMedicalAppontmentData(){
        return MedicalAppointment::factory()
        ->make()
        ->toArray();
    }

    /**
     * @group index
     * @group medical-appointment
     * @group medical-appointment.index
     * @group patient.medical-appointment
     * @group patient.medical-appointment.index
     */
    public function testIndex(){
        $patient = Patient::has('medicalAppointments')
        ->with('medicalAppointments')
        ->inRandomOrder()
        ->first();

        $this->json('GET', route('patient.medical-appointment.index', [
            'patient' => $patient
        ]));

        $this->seeStatusCode(Response::HTTP_OK);

        $this->seeJsonStructure([
            'data' => [],
            'meta' => [
                'pagination' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                    'links'
                ]
            ]
        ]);
    }

    /**
     * @group show
     * @group medical-appointment
     * @group medical-appointment.show
     * @group patient.medical-appointment
     * @group patient.medical-appointment.show
     */
    public function testShow(){
        $patient = Patient::has('medicalAppointments')
        ->with('medicalAppointments')
        ->inRandomOrder()
        ->first();

        $this->json('GET', route('patient.medical-appointment.show', [
            'patient' => $patient->id,
            'id' => $patient->medicalAppointments->first()->id
        ]));

        $this->seeStatusCode(Response::HTTP_OK);

        $this->seeJsonStructure([
            'data' => [
                'id'
            ]
        ]);
    }

    /**
     * @group store
     * @group medical-appointment
     * @group medical-appointment.store
     * @group patient.medical-appointment
     * @group patient.medical-appointment.store
     */
    public function testStore(){
        $payload = $this->getTestMedicalAppontmentData();

        $patient = Patient::inRandomOrder()->first();

        $this->json('POST', route('patient.medical-appointment.store', [
            'patient' => $patient->id
        ]), $payload);

        $this->seeStatusCode(Response::HTTP_CREATED);

        $this->seeJsonStructure([
            'data' => [
                'id'
            ]
        ]);

        $this->seeInDatabase($this->table, [
            'patient_id' => $patient->id,
            'record' => $payload['record']
        ]);
    }

    /**
     * @group update
     * @group medical-appointment
     * @group medical-appointment.update
     * @group patient.medical-appointment
     * @group patient.medical-appointment.update
     */
    public function testUpdate(){
        $patient = Patient::has('medicalAppointments')
        ->with('medicalAppointments:id,patient_id')
        ->inRandomOrder()
        ->first();

        $id = $patient->medicalAppointments
        ->first()
        ->id;

        $payload = $this->getTestMedicalAppontmentData();

        $this->json('PUT', route('patient.medical-appointment.update', [
            'patient' => $patient->id,
            'id' => $id
        ]), $payload);

        $this->seeStatusCode(Response::HTTP_OK);

        $this->seeJsonStructure([
            'data' => [
                'id',
                'created_at',
                'updated_at'
            ]
        ]);

        $this->seeInDatabase($this->table, [
            'id' => $id,
            'patient_id' => $patient->id,
            'record' => $payload['record'],
        ]);
    }

    /**
     * @group destroy
     * @group medical-appointment
     * @group medical-appointment.destroy
     * @group patient.medical-appointment
     * @group patient.medical-appointment.destroy
     */
    public function testDestroy(){
        $patient = Patient::has('medicalAppointments')
        ->with('medicalAppointments:id,patient_id')
        ->inRandomOrder()
        ->first();

        $id = $patient->medicalAppointments
        ->first()
        ->id;

        $this->json('DELETE', route('patient.medical-appointment.destroy', [
            'patient' => $patient->id,
            'id' => $id
        ]));

        $this->seeStatusCode(Response::HTTP_NO_CONTENT);

        $this->notSeeInDatabase($this->table, [
            'id' => $id,
            'patient_id' => $patient->id,
            'deleted_at' => null
        ]);
    }

    /**
     * @group validation
     * @group medical-appointment
     * @group medical-appointment.validation
     * @group patient.medical-appointment
     * @group patient.medical-appointment.validation
     */
    public function testAssertRequiredData(){
        $patient = Patient::has('medicalAppointments')
        ->with('medicalAppointments:id,patient_id')
        ->inRandomOrder()
        ->first();

        $payload = $this->getTestMedicalAppontmentData();

        $lastID = MedicalAppointment::select('id')
        ->orderBy('id', 'desc')
        ->first()
        ->id;

        foreach ($payload as $key => $value) {
            $payload[$key] = null;
        }

        $this->json('POST', route('patient.medical-appointment.store', [
            'patient' => $patient->id
        ]), $payload);

        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->seeJsonStructure(array_keys($payload));

        $this->notSeeInDatabase($this->table, [
            'id' => ($lastID + 1),
        ]);
    }
}
