<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// This route will return a simple welcome view
Route::get('/', function () {
    return view('welcome');
});

// This route is used to setup the initial user and tokens for authentication
Route::get('/setup', function() {

    // These are the credentials for the initial admin user
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password'
    ];

    // Try to authenticate with the given credentials
    if (!Auth::attempt($credentials)) {

        // If authentication fails, create a new user with the given credentials
        $user = new \App\Models\User();

        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
    
        $user->save();

        // Authenticate with the newly created user
        if (Auth::attempt($credentials)) {

            // Get the authenticated user and create three different tokens with different scopes
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', ['create','update','delete']);
            $updateToken = $user->createToken('update-token', ['create','update']);
            $basicToken = $user->createToken('basic-token');

            // Return the three different tokens as plain text
            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken,
            ];
        }
    }
});
