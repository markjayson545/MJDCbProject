<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserAccount extends Model
{
    protected $table = 'user_accounts';

    protected $fillable = [
        'username',
        'email',
        'role',
        'password',
        'is_active',
        'password_changed_at',
    ];

    protected function casts(): array
    {
        return [
            'password_changed_at' => 'datetime',
        ];
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_account_id');
    }

    public function students(): HasOne
    {
        return $this->student();
    }
}
