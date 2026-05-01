<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'PERSONAL_INFORMATION';
    protected $primaryKey = 'personal_id';

    public $timestamps = false;

    protected $fillable = [
        'firstName',
        'lastName',
        'father',
        'mother',
        'birthday',
        'gender',
        'national_number',
        'phone',
        'email',
        'address',
        'salary',
        'department_id',
        'role_id',
        'employee_status_id',
        'upload_file'
    ];



    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
   public function status()
    {
        return $this->belongsTo(
            EmployeeStatus::class,
            'employee_status_id',
            'employee_status_id'
        );
    }
}