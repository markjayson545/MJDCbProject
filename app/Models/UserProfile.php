<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfile extends Model
{
    protected $fillable = [
        'username',
        'password',
    ];

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }
}
