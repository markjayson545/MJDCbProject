<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        // Add degree_id foreign key
        'degree_id',
        // Add course_id as foreign key, many to many relationship
        'course_id',
    ];

    /**
     * Degree relationship (student belongs to degree)
     */
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }
}
