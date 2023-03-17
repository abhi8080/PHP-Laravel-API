<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Check if the user is authenticated and has permission to create invoices
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Define the validation rules for the request.
        return [
            '*.customerId' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Transform the data from the request to match the validation rules.
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date'] = $obj['paidDate'] ?? null;

            $data[] = $obj;
        }

        // Merge the transformed data back into the request.
        $this->merge($data);
    }
}
