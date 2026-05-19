<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

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

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher', 'course_id', 'teacher_id')
            ->withTimestamps();
    }

    public function degrees(): BelongsToMany
    {
        return $this->belongsToMany(Degree::class, 'degree_subject', 'course_id', 'degree_id')
            ->withTimestamps();
    }
}
