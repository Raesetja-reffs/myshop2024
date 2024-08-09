<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'strGroupName' => [
                'required',
                'string',
                'max:255',
            ],
            'strGroupDescription' => [
                'nullable',
                'string',
                'max:255',
            ],
            'kt_docs_repeater_nested_outer' => 'nullable',
            'kt_docs_repeater_nested_outer.*.user_id' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'strGroupName' => 'group name',
            'strGroupDescription' => 'group description',
            'kt_docs_repeater_nested_outer.*.user_id' => 'user',
        ];
    }
}