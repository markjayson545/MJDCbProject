<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $table = 'courses';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'title',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id')
            ->using(CourseStudent::class)
            ->withTimestamps();
    }
}
