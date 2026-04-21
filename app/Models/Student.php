<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $table = 'students';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contactno',
        'description',
        'degree_id',
        'user_account_id',
        'user_profile_id',
    ];

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
            ->using(\App\Models\CourseStudent::class)
            ->withTimestamps();
    }

    public function userProfile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function userAccount(): BelongsTo
    {
        return $this->hasOne(UserAccount::class);
    }
}
