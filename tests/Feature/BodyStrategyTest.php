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

class BodyStrategyTest extends TestCase
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
    public function testBodySuccess()
    {
        $this->endpoint = factory(Endpoint::class)->create([

            'name' => 'Domain with Body will give 200 status code.',
            'url' => 'http://www.webtraders.nl',
            'instance_id' => $this->instance->id,
        ]);

        $this->procedure = factory(Procedure::class)->create([
            'type' => ProcedureType::getKey(ProcedureType::BODY),
            'endpoint_id' => $this->endpoint->id,
        ]);

        $field = factory(Field::class)->create([
            'handle' => 'body',
            'value' => 'Webtraders 2020',
            'procedure_id' => $this->procedure->id,
        ]);

        $this->procedureService = new ProcedureService($this->procedure);

        self::assertTrue($this->procedureService->process());
        self::assertEquals(ProcedureType::getKey(ProcedureType::BODY), $this->procedure->type);
        self::assertDatabaseHas('procedures', ['id' => $this->procedure->id, 'status' => 1]);
        self::assertEquals(200, $this->procedure->code);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBodyFailed()
    {
        $this->endpoint = factory(Endpoint::class)->create([

            'name' => 'Domain with Body will give 404 status code.',
            'url' => 'http://www.webtraders.nl',
            'instance_id' => $this->instance->id,
        ]);

        $this->procedure = factory(Procedure::class)->create([
            'type' => ProcedureType::getKey(ProcedureType::BODY),
            'endpoint_id' => $this->endpoint->id,
        ]);

        $field = factory(Field::class)->create([
            'handle' => 'body',
            'value' => 'Foutive content',
            'procedure_id' => $this->procedure->id,
        ]);

        $this->procedureService = new ProcedureService($this->procedure);

        self::assertFalse($this->procedureService->process());
        self::assertEquals(ProcedureType::getKey(ProcedureType::BODY), $this->procedure->type);
        self::assertEquals(422, $this->procedure->code);
    }
}
