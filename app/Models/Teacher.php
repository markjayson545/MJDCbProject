<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contactno',
        'email',
        'department',
        'description',
        'user_account_id',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'teacher_id', 'course_id')
            ->withTimestamps();
    }

    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class);
    }
}
