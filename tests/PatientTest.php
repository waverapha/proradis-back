<?php

use App\Models\Patient;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\{
    DatabaseMigrations,
    DatabaseTransactions
};

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    private $table = 'patients';

    /**
     * @group index
     * @group student
     * @group student.index
     */
    public function testIndex(){
        $this->json('GET', route('patient.index'));

        $this->seeStatusCode(Response::HTTP_OK);

        $this->seeJsonStructure([
            'data'
        ]);
    }

    /**
     * @group show
     * @group student
     * @group student.show
     */
    public function testShow(){
        $this->json('GET', route('patient.show', [
            'id' => 1
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
        $payload = Patient::factory()
        ->make()
        ->toArray();

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
        $id = 2;

        $payload = Patient::factory()
        ->make()
        ->toArray();

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
        $id = 3;

        $this->json('DELETE', route('patient.destroy', [
            'id' => $id
        ]));

        $this->seeStatusCode(Response::HTTP_NO_CONTENT);

        $this->notSeeInDatabase('patients', [
            'id' => $id,
            'deleted_at' => null
        ]);
    }
}
