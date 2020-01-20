<?php

namespace App\Http\Controllers\API;

use App\Models\Log;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    protected $rules = [
        'code' => '',
        'reason' => '',
        'procedure_id' => '',
    ];

    public function index()
    {
        $logs = Log::all();

        return $logs->toArray();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);

        $log = Log::create($validated);

        return $log;
    }

    /**
     * @param Log $log
     * @return Log
     */
    public function show(Log $log)
    {
        return $log;
    }

    /**
     * @param Request $request
     * @param Log $log
     * @return Log
     */
    public function update(Request $request, Log $log)
    {
        $validated = $request->validate($this->rules);
        $log->update($validated);
        return $log;
    }

    /**
     * @param Log $log
     * @return Log[]|Collection
     */
    public function destroy(Log $log)
    {
        tap($log)->delete();
        return Log::all();
    }
}
