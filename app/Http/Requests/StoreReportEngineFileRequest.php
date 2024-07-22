<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\CentralUser;

class StoreReportEngineFileRequest extends FormRequest
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
        $validationArr = [];
        $validationArr['company_id'] = ['required', 'string', 'max:255'];
        $validationArr['company_name'] = ['nullable'];
        $validationArr['file_url'] = ['nullable', 'file'];

        return $validationArr;
    }

    public function attributes()
    {
        return [
            'company_id' => 'company name',
        ];
    }
}
