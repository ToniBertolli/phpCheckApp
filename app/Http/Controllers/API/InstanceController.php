<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Instance;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstanceController extends Controller
{
    protected $rules = [
        'name' => 'required',
        'logo' => 'nullable',
        'user_id' => 'required'
    ];

    public function index()
    {
        $instances = \request('user_id') ? Instance::with('endpoints.procedures.logs')->where('user_id', \request('user_id'))->get() : Instance::with('endpoints.procedures.logs')->get();

        return $instances->toArray();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $instance = Instance::create($validated);
        return $instance;
    }

    /**
     * @param Instance $instance
     * @return Instance
     */
    public function show(Instance $instance)
    {
        return $instance;
    }

    /**
     * @param Request $request
     * @param Instance $instance
     * @return Instance
     */
    public function update(Request $request, Instance $instance)
    {
        $validated = $request->validate($this->rules);
        $instance->update($validated);
        return $instance;
    }

    /**
     * @param Instance $instance
     * @return Instance[]|Collection
     */
    public function destroy(Instance $instance)
    {
        tap($instance)->delete();
        return Instance::all();
    }
}
