<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Filters\V1\CustomersFilter;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Create a new instance of the CustomersFilter class
        $filter = new CustomersFilter();
        // Get the filter items from the request using the transform method of the CustomersFilter class
        $filterItems = $filter->transform($request); // returns an array of [['column', 'operator', 'value']]

        // Get the includeInvoices query parameter from the request
        $includeInvoices = $request->query('includeInvoices');

        // Get all the customers from the database where the filterItems match
        $customers = Customer::where($filterItems);
        
        // If includeInvoices is present, eager load the invoices relationship
        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        // Return a new CustomerCollection resource with the paginated customers and any query parameters
        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        // Create a new Customer resource from the request data and return it
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        // Get the includeInvoices query parameter from the request
        $includeInvoices = request()->query('includeInvoices');

        // If includeInvoices is present, load the missing invoices relationship and return a new CustomerResource
        if ($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        // Return a new CustomerResource
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        // Update the customer with the request data
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        // Delete the customer from the database
        $customer->delete();
    }
}
