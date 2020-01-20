<?php

namespace App\Http\Controllers\API;

use App\Enums\ProcedureType;
use App\Http\Controllers\Controller;
use App\Models\Endpoint;
use App\Models\Procedure;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EndpointController extends Controller
{
    protected $rules = [
        'name' => 'min:3|max:255',
        'url' => 'url',
        'status' => '',
        'instance_id' => '',
    ];

    /**
     * @return Endpoint[]|Collection
     */
    public function index()
    {
        $endpoints = \request('instance_id') ? Endpoint::with('procedures')->get()->where('instance_id', \request('instance_id')) : Endpoint::with('procedures')->get();

        return $endpoints->toArray();
    }

    /**
     * @param Request $request
     * @return voids
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $endpoint = Endpoint::create($validated);
        Procedure::create([
            'type' => ProcedureType::REQUEST,
            'endpoint_id' => $endpoint->id

        ]);
        return $endpoint;
    }

    /**
     * @param Endpoint $endpoint
     * @return Endpoint
     */
    public function show(Endpoint $endpoint)
    {
        return $endpoint;
    }

    /**
     * @param Request $request
     * @param Endpoint $endpoint
     * @return Endpoint
     */
    public function update(Request $request, Endpoint $endpoint)
    {
        $validated = $request->validate($this->rules);
        $endpoint->update($validated);
        return $endpoint;
    }

    /**
     * @param Endpoint $endpoint
     * @return Endpoint[]|Collection
     */
    public function destroy(Endpoint $endpoint)
    {
        tap($endpoint)->delete();
        return Endpoint::all();
    }
}
