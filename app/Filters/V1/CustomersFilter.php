<?php


use App\Filters\ApiFilter;

namespace App\Filters\V1; // Define the namespace
use Illuminate\Http\Request; // Import the Request class from the Illuminate\Http namespace

use App\Filters\ApiFilter;

class CustomersFilter extends ApiFilter { // Define the CustomerFilter class
    protected $safeParms = [ // Define an array of safe query parameters
        'name' => ['eq'], // Define the "name" parameter with the "eq" operator
        'type' => ['eq'], // Define the "type" parameter with the "eq" operator
        'email' => ['eq'], // Define the "email" parameter with the "eq" operator
        'address' => ['eq'], // Define the "address" parameter with the "eq" operator
        'city' => ['eq'], // Define the "city" parameter with the "eq" operator
        'state' => ['eq'], // Define the "state" parameter with the "eq" operator
        'postalCode' => ['eq', 'gt', 'lt'], // Define the "postalCode" parameter with the "eq", "gt", and "lt" operators
    ];

    protected $columnMap = [ // Define an array that maps the parameter names to their corresponding column names
        'postalCode' => 'postal_code', // Map the "postalCode" parameter to the "postal_code" column
    ];

    protected $operatorMap = [ // Define an array that maps operators to their corresponding database operators
        'eq' => '=', // Map the "eq" operator to the "=" operator
        'gt' => '>', // Map the "gt" operator to the ">" operator
        'lt' => '<', // Map the "lt" operator to the "<" operator
        'lte' => '<=', // Map the "lte" operator to the "<=" operator
        'gte' => '>=', // Map the "gte" operator to the ">=" operator
    ];
}
