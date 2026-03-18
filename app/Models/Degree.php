<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $table = 'degrees';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'name',
    ];
}
