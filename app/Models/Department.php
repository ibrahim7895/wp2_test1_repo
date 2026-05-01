<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'DEPARTMENT';
    protected $primaryKey = 'department_id';

    public $timestamps = false;

    protected $fillable = [
        'department_name'
    ];
}