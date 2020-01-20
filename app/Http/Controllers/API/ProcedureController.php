<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Enums\ProcedureType;
use App\Models\Procedure;
use BenSampo\Enum\Rules\EnumKey;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProcedureController extends Controller
{
    protected static function rules()
    {
        return [
            'code' => ['sometimes', 'min:3', 'max:3'],
            'status' => 'sometimes',
            'type' => ['required' , new EnumKey(ProcedureType::class)],
            'interval' => 'sometimes',
            'endpoint_id' => 'sometimes',
        ];
    }

    public function index()
    {
        $procedures = Procedure::where('endpoint_id', \request('endpoint_id'))->with('endpoint')->with('fields')->get();
        return response($procedures->toArray(), 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $procedure = Procedure::create($validated);
        return $procedure;
    }

    /**
     * @param Procedure $procedure
     * @return Procedure
     */
    public function show(Procedure $procedure)
    {
        return $procedure;
    }

    /**
     * @param Request $request
     * @param Procedure $procedure
     * @return Procedure
     */
    public function update(Request $request, Procedure $procedure)
    {
        $validated = $request->validate($this->rules());
        $procedure->update($validated);
        return $procedure;
    }

    /**
     * @param Procedure $procedure
     * @return Procedure[]|Collection
     */
    public function destroy(Procedure $procedure)
    {
        tap($procedure)->delete();
        return Procedure::all();
    }
}
