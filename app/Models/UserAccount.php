<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccount extends Model
{
    protected $table = 'user_accounts';

    protected $fillable = [
        'username',
        'email',
        'role',
        'password',
        'is_active',
    ];

    public function students(): BelongsTo
    {
        return $this->hasOne(Student::class);
    }
}
