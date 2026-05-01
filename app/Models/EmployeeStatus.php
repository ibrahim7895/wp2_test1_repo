<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeStatus extends Model
{
    protected $table = 'EMPLOYEE_STATUS';
    protected $primaryKey = 'employee_status_id';
    public $timestamps = false;

    protected $fillable = ['status'];
}
