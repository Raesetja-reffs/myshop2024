<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $uniqueValidation = Rule::unique('report_builder_files')->where(function ($query) {
            return $query->where('report_type', $this->report_type);
        });
        if (isset($this->report_builder_file->id)) {
            $uniqueValidation = $uniqueValidation->ignore($this->report_builder_file->id);
        }

        return [
            'company_id' => [
                'required',
                'string',
                'max:255',
                $uniqueValidation,
            ],
            'company_name' => ['nullable'],
            'report_type' => ['required', 'string'],
            'file_url' => [
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    $allowedMimeTypes = ['application/octet-stream'];
                    $fileMimeType = $value->getMimeType();

                    if (!in_array($fileMimeType, $allowedMimeTypes) && $value->getClientOriginalExtension() !== 'repx') {
                        $fail('The file must be of type application/octet-stream or have a .repx extension.');
                    }
                },
                'max:2048',
            ],

        ];
    }

    public function messages()
    {
        return [
            'company_id.unique' => 'This company has already submitted a file of the same report type.',
        ];
    }

    public function attributes()
    {
        return [
            'company_id' => 'company name',
            'file_url' => 'report file'
        ];
    }
}
