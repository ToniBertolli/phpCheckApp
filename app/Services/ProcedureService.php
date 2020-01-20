<?php

namespace App\Services;

use App\Enums\ProcedureType;
use App\Events\CheckedProcedure;
use App\Events\ProcedureChanged;
use App\Helpers\ProcedureStrategy\ApiStrategy;
use App\Helpers\ProcedureStrategy\BodyStrategy;
use App\Helpers\ProcedureStrategy\RequestStrategy;
use App\Models\Log;
use App\Models\Procedure;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ProcedureService
{
    public $procedure;
    private $client;
    private $strategy;

    public function __construct(Procedure $procedure)
    {
        $this->procedure = $procedure;
        $this->strategy = $this->chooseStrategy();
    }

    private function chooseStrategy()
    {
        switch (ProcedureType::getValue($this->procedure->type))
        {
            case ProcedureType::REQUEST:
                return new RequestStrategy();
                break;
            case ProcedureType::BODY:
                return new BodyStrategy();
                break;
            case ProcedureType::API:
                return new ApiStrategy();
                break;
        }
    }

    public function process()
    {
        if($this->stopOnInterval()) {
            return true;
        }

        $log = new Log();
        $log->procedure_id = $this->procedure->id;

        $this->client = new Client();
        try {
            $resp = $this->strategy->process($this->client, $this->procedure, $log);
            !$this->procedure->isChanged($resp->getStatusCode(), true) ?: $this->update($resp->getStatusCode(), $resp->getReasonPhrase(), true);
            $log->code = $resp->getStatusCode();
            $log->reason = $resp->getReasonPhrase();
            $log->status = true;
        } catch (\Exception $e) {
            $log->code = $e->getCode();
            $log->reason = $e->getMessage();
            $log->status = false;
            !$this->procedure->isChanged($e->getCode(),false) ?: $this->update($e->getCode(), $e->getMessage(), false);
        }
        $log->save();
        event(new CheckedProcedure($this->procedure->id));
        return $log->status;
    }

    public function update($code, $reason, $status)
    {
        $this->procedure->update([
            'code' => $code,
            'status' => $status
        ]);
        event(new ProcedureChanged($reason));
    }

    private function stopOnInterval() {
        if( !is_null($this->procedure->logs->first()))
        {
            $interval = $this->procedure->interval;
            $total = Carbon::now()->diffInMinutes($this->procedure->logs->first()->created_at);


            if($total < $interval) {
                return true;
            }
            return false;
        }
    }
}
