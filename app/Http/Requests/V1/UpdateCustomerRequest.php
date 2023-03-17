<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Get the authenticated user making the request
        $user = $this->user();

        // Check if the user is not null and has the 'update' permission
        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get the HTTP request method
        $method = $this->method();

        // Define validation rules for the 'PUT' request method
        if ($method == 'PUT') {
            return [
                'name' => ['required'],
                'type' => ['required', Rule::in(['I', 'B', 'i', 'b'])],
                'email' => ['required', 'email'],
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'postalCode'  => ['required'],
            ];
        } 
        // Define validation rules for all other request methods
        else {
            return [
                'name' => ['sometimes', 'required'],
                'type' => ['sometimes', 'required', Rule::in(['I', 'B', 'i', 'b'])],
                'email' => ['sometimes', 'required', 'email'],
                'address' => ['sometimes', 'required'],
                'city' => ['sometimes', 'required'],
                'state' => ['sometimes', 'required'],
                'postalCode'  => ['sometimes', 'required'],
            ]; 
        }
    }

    /**
     * Modify input data before validation.
     *
     * @return void
     */
    protected function prepareForValidation() {
        // Check if the 'postalCode' field exists in the input data
        if ($this->postalCode) {
            // Merge a new 'postal_code' field into the input data with the value of the 'postalCode' field
            $this->merge([
                'postal_code' => $this->postalCode
            ]);
        }
    }
}
