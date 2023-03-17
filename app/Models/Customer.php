<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import the HasFactory trait to use it in this model
use Illuminate\Database\Eloquent\Model; // Import the Model class to extend it

class Customer extends Model // Define the Customer model and extend the Model class
{
    use HasFactory; // Use the HasFactory trait in this model

    protected $fillable = [ // Define an array of attributes that are mass assignable
        'name',
        'type',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
    ];


    public function invoices() { // Define a one-to-many relationship between the Customer and Invoice models
        return $this->hasMany(Invoice::class);
    }
}
