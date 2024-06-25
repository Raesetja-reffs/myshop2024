<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\CentralUser;

class UpdateCentralUserRequest extends FormRequest
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
        $validationArr = [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(CentralUser::class)->ignore($this->central_user->id),
            ],
            'erp_apiurl' => ['required', 'string', 'max:255'],
            'erp_apiusername' => ['required', 'string', 'max:255'],
            'erp_apipassword' => ['required', 'string', 'max:255'],
            'erp_apiauthtoken' => ['required', 'string', 'max:255'],
            'location_id' => ['required', 'string', 'max:255'],
        ];
        if (auth()->guard('central_api_user')->user()->isAdmin()) {
            $validationArr['company_id'] = ['required', 'string', 'max:255'];
        }

        return $validationArr;
    }

    public function attributes()
    {
        return [
            'company_id' => 'company name',
        ];
    }
}
