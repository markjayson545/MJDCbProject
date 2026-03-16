<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Student model representing the 'students' table in the database
    protected $table = 'students';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        // Define fillable attributes for mass assignment
        'fname',
        'mname',
        'lname',
        'contactno',
        'email',
        'description',
        // Add other relevant fields as needed
    ];
}
