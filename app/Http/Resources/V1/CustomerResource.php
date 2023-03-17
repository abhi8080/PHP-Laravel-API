<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable  The transformed resource as an array, arrayable, or JSON serializable
     */
    public function toArray($request)
    {
        // Return an array with the following keys and their corresponding values from the resource
        return [
            'id' => $this->id,  // The ID of the customer
            'name' => $this->name,  // The name of the customer
            'type' => $this->type,  // The type of the customer
            'email' => $this->email,  // The email address of the customer
            'address' => $this->address,  // The street address of the customer
            'city' => $this->city,  // The city where the customer is located
            'state' => $this->state,  // The state where the customer is located
            'postalCode' => $this->postal_code,  // The postal code of the customer
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),  // A collection of invoices associated with the customer
        ];
    }
}
