<?php

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\{
    DatabaseMigrations,
    DatabaseTransactions
};

class PatientTest extends TestCase
{
    use DatabaseTransactions;

    private $table = 'patients';

    public function getTestPacientData(){
        return Patient::factory()
        ->make()
        ->toArray();
    }

    /**
     * @group index
     * @group student
     * @group student.index
     */
    public function testIndex(){
        $this->json('GET', route('patient.index'));

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
     * @group student
     * @group student.show
     */
    public function testShow(){
        $id = Patient::select('id')
        ->inRandomOrder()
        ->first()
        ->id;

        $this->json('GET', route('patient.show', [
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
     * @group student
     * @group student.store
     */
    public function testStore(){
        $payload = $this->getTestPacientData();

        $this->json('POST', route('patient.store'), $payload);

        $this->seeStatusCode(Response::HTTP_CREATED);

        $this->seeJsonStructure([
            'data' => [
                'id'
            ]
        ]);

        $this->seeInDatabase('patients', [
            'name' => $payload['name'],
            'document' => $payload['document']
        ]);
    }

    /**
     * @group update
     * @group student
     * @group student.update
     */
    public function testUpdate(){
        $id = Patient::select('id')
        ->inRandomOrder()
        ->first()
        ->id;

        $payload = $this->getTestPacientData();

        $this->json('PUT', route('patient.update', [
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

        $this->seeInDatabase('patients', [
            'id' => $id,
            'name' => $payload['name'],
            'document' => $payload['document']
        ]);
    }

    /**
     * @group destroy
     * @group student
     * @group student.destroy
     */
    public function testDestroy(){
        $id = Patient::select('id')
        ->inRandomOrder()
        ->first()
        ->id;

        $this->json('DELETE', route('patient.destroy', [
            'id' => $id
        ]));

        $this->seeStatusCode(Response::HTTP_NO_CONTENT);

        $this->notSeeInDatabase('patients', [
            'id' => $id,
            'deleted_at' => null
        ]);
    }

    /**
     * @group validation
     * @group student
     * @group student.validation
     */
    public function testAssertRequiredData(){
        $payload = $this->getTestPacientData();

        $lastID = Patient::select('id')
        ->orderBy('id', 'desc')
        ->first()
        ->id;

        foreach ($payload as $key => $value) {
            $payload[$key] = null;
        }

        $this->json('POST', route('patient.store'), $payload);

        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->seeJsonStructure(array_keys($payload));

        $this->notSeeInDatabase('patients', [
            'id' => ($lastID + 1),
        ]);
    }
}
