<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportBuilderFileRequest extends FormRequest
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
            'company_id' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable'],
            'report_type' => ['required', 'string'],
            'file_url' => ['required', 'file'],
        ];
    }

    public function attributes()
    {
        return [
            'company_id' => 'company name',
        ];
    }
}
