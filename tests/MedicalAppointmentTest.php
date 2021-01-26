<?php

use App\Models\MedicalAppointment;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\{
    DatabaseMigrations,
    DatabaseTransactions
};

class MedicalAppointmentTest extends TestCase
{
    use DatabaseTransactions;

    private $table = 'medical_appointments';

    public function getTestPacientData(){
        return MedicalAppointment::factory()
        ->make()
        ->toArray();
    }

    /**
     * @group index
     * @group medical-appointment
     * @group medical-appointment.index
     */
    public function testIndex(int $patient){
        $this->json('GET', route('medical-appointment.index', [
            'patient' => $patient
        ]));

        $this->seeStatusCode(Response::HTTP_OK);

        $this->seeJsonStructure([
            'data',
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
     */
    public function testShow(){
        $id = MedicalAppointment::select('id')
        ->inRandomOrder()
        ->first()
        ->id;

        $this->json('GET', route('medical-appointment.show', [
            'id' => $id
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
     */
    public function testStore(){
        $payload = $this->getTestPacientData();

        $this->json('POST', route('medical-appointment.store'), $payload);

        $this->seeStatusCode(Response::HTTP_CREATED);

        $this->seeJsonStructure([
            'data' => [
                'id'
            ]
        ]);

        $this->seeInDatabase($this->table, [
            'name' => $payload['name'],
            'document' => $payload['document']
        ]);
    }

    /**
     * @group update
     * @group medical-appointment
     * @group medical-appointment.update
     */
    public function testUpdate(){
        $id = MedicalAppointment::select('id')
        ->inRandomOrder()
        ->first()
        ->id;

        $payload = $this->getTestPacientData();

        $this->json('PUT', route('medical-appointment.update', [
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
            'name' => $payload['name'],
            'document' => $payload['document']
        ]);
    }

    /**
     * @group destroy
     * @group medical-appointment
     * @group medical-appointment.destroy
     */
    public function testDestroy(){
        $id = MedicalAppointment::select('id')
        ->inRandomOrder()
        ->first()
        ->id;

        $this->json('DELETE', route('medical-appointment.destroy', [
            'id' => $id
        ]));

        $this->seeStatusCode(Response::HTTP_NO_CONTENT);

        $this->notSeeInDatabase($this->table, [
            'id' => $id,
            'deleted_at' => null
        ]);
    }

    /**
     * @group validation
     * @group medical-appointment
     * @group medical-appointment.validation
     */
    public function testAssertRequiredData(){
        $payload = $this->getTestPacientData();

        $lastID = MedicalAppointment::select('id')
        ->orderBy('id', 'desc')
        ->first()
        ->id;

        foreach ($payload as $key => $value) {
            $payload[$key] = null;
        }

        $this->json('POST', route('medical-appointment.store'), $payload);

        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->seeJsonStructure(array_keys($payload));

        $this->notSeeInDatabase($this->table, [
            'id' => ($lastID + 1),
        ]);
    }
}
