<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'department_name',
        'hod_name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Students
    |--------------------------------------------------------------------------
    */

    public function students()
    {
        return $this->hasMany(Student::class, 'department_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Faculty
    |--------------------------------------------------------------------------
    */

    public function faculty()
    {
        return $this->hasMany(Faculty::class, 'department_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Courses
    |--------------------------------------------------------------------------
    */

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Subjects
    |--------------------------------------------------------------------------
    */

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'department_subject',
            'department_id',
            'subject_id',
            'id',
            'subject_id'
        );
    }
}