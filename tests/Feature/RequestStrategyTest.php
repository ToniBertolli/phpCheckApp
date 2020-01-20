<?php

namespace Tests\Feature;

use App\Enums\FieldType;
use App\Enums\ProcedureType;
use App\Models\Instance;
use App\Models\Endpoint;
use App\Models\Field;
use App\Models\Procedure;
use App\Services\ProcedureService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RequestStrategyTest extends TestCase
{
    use RefreshDatabase;

    /** @var Instance */
    private $instance;
    /** @var Endpoint */
    private $endpoint;
    /** @var Procedure */
    private $procedure;
    /** @var ProcedureService */
    private $procedureService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->instance = factory(Instance::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequestSuccess()
    {
        $this->endpoint = factory(Endpoint::class)->create([
            'name' => 'Domain with Request will give 200 status code.',
            'url' => 'http://www.google.com',
            'instance_id' => $this->instance->id,
        ]);

        $this->procedure = factory(Procedure::class)->create([
            'type' => ProcedureType::getKey(ProcedureType::REQUEST),
            'endpoint_id' => $this->endpoint->id,
        ]);

        $this->procedureService = new ProcedureService($this->procedure);

        self::assertTrue($this->procedureService->process());
        self::assertEquals(ProcedureType::getKey(ProcedureType::REQUEST), $this->procedure->type);
        self::assertEquals(200, $this->procedure->code);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequestFailed()
    {
        $this->endpoint = factory(Endpoint::class)->create([
            'name' => 'Domain with Request will give 404 status code.',
            'url' => 'https://leaseplan.space-lms.com/',
            'instance_id' => $this->instance->id,
        ]);

        $this->procedure = factory(Procedure::class)->create([
            'type' => ProcedureType::getKey(ProcedureType::REQUEST),
            'endpoint_id' => $this->endpoint->id,
        ]);

        $this->procedureService = new ProcedureService($this->procedure);

        self::assertFalse($this->procedureService->process());
        self::assertEquals(ProcedureType::getKey(ProcedureType::REQUEST), $this->procedure->type);
        self::assertEquals(404, $this->procedure->code);
    }
}
