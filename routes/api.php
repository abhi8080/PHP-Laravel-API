<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// This route requires authentication via Sanctum middleware and returns the authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// This group of routes all begin with the prefix 'v1' and are handled by controllers within the 'App\Http\Controllers\Api\V1' namespace
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function() {
    // This route is a RESTful resource route that maps HTTP verbs to controller actions for the 'customers' resource
    Route::apiResource('customers', CustomerController::class);
    
    // This route is a RESTful resource route that maps HTTP verbs to controller actions for the 'invoices' resource
    Route::apiResource('invoices', InvoiceController::class);

    // This route is a custom route that maps a POST request to the 'bulkStore' method on the InvoiceController
    Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);
});
