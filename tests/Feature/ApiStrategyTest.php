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
use Tests\TestCase;

class ApiStrategyTest extends TestCase
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
    public function testApiFailed()
    {
        $this->endpoint = factory(Endpoint::class)->create([
            'name' => 'Righttowork',
            'url' => 'http://righttowork.valicare.nl/test',
            'instance_id' => $this->instance->id,
        ]);

        $this->procedure = factory(Procedure::class)->create([
            'type' => ProcedureType::getKey(ProcedureType::API),
            'endpoint_id' => $this->endpoint->id,
        ]);

        $fotofield = factory(Field::class)->create([
            'type' => FieldType::getKey(FieldType::FILE),
            'handle' => 'file',
            'value' => 'testfoto.jpg',
            'procedure_id' => $this->procedure->id,
        ]);

        $apifield = factory(Field::class)->create([
            'handle' => 'api_token',
            'value' => 'a9Bi3GfeBXQ4HHoAGbudw6Hyz8vV89kxg',
            'procedure_id' => $this->procedure->id,
        ]);

        $typefield = factory(Field::class)->create([
            'handle' => 'type',
            'value' => 'residence',
            'procedure_id' => $this->procedure->id,
        ]);

        $datefield = factory(Field::class)->create([
            'handle' => 'expiry_date',
            'value' => '17-06-2020',
            'procedure_id' => $this->procedure->id,
        ]);

        $callbackfield = factory(Field::class)->create([
            'handle' => 'callback',
            'value' => 'http://righttowork.localhost/test',
            'procedure_id' => $this->procedure->id,
        ]);

        $this->procedureService = new ProcedureService($this->procedure);
        $this->procedureService->process();
        self::assertFalse($this->procedureService->process());
        self::assertEquals(ProcedureType::getKey(ProcedureType::API), $this->procedure->type);
        self::assertEquals(404, $this->procedure->logs()->first()->code);
    }
}
