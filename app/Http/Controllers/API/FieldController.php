<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Enums\FieldType;
use App\Models\Field;
use BenSampo\Enum\Rules\EnumKey;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FieldController extends Controller
{
    protected static function rules()
    {
        return [
            'type' => 'sometimes',
//            'type' => ['required' , 'integer', new EnumKey(FieldType::class)],
            'handle' => 'sometimes',
            'value' => 'sometimes',
            'procedure_id' => 'sometimes'
        ];
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function index(Request $request)
    {
        $procedure_id = $request->input('procedure_id');
        $fields = Field::where('procedure_id', $procedure_id)->with('procedure')->get();
        return response($fields->toArray(), 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['type'] = FieldType::getInstance(FieldType::TEXT);
        $field = Field::create($validated);
        return $field;
    }

    /**
     * @param Field $field
     * @return Field
     */
    public function show(Field $field)
    {
        return $field;
    }

    /**
     * @param Request $request
     * @param Field $field
     * @return Field
     */
    public function update(Request $request, Field $field)
    {
//        $request['type'] = ProcedureType::BODY;

        $validated = $request->validate($this->rules());
        //$procedure->update(['type' => ProcedureType::getValue(ProcedureType::BODY)]);
        $field->update($validated);
        return $field;
    }

    /**
     * @param Field $field
     * @return Field[]|Collection
     */
    public function destroy(Field $field)
    {
        tap($field)->delete();
        return Field::all();
    }
}
