<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Degree extends Model
{
    use HasFactory;

    protected $table = 'degrees';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'name',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'degree_subject', 'degree_id', 'course_id')
            ->withTimestamps();
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'degree_id');
    }
}
