<?php

use App\Models\MedicalAppointment;
use App\Models\Patient;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\{
    DatabaseMigrations,
    DatabaseTransactions
};

class MedicalAppointmentTest extends TestCase
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
     */
    public function testIndex(){
        $this->json('GET', route('medical-appointment.index'));

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
     */
    public function testShow(){
        $id = MedicalAppointment::inRandomOrder()
        ->first()
        ->id;

        $this->json('GET', route('medical-appointment.show', [
            'id' => $id,
        ]));

        $this->seeStatusCode(Response::HTTP_OK);

        $this->seeJsonStructure([
            'data' => [
                'id'
            ]
        ]);
    }
}
