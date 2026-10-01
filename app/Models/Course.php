<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $fillable = [
        'department_id',
        'course_code',
        'course_name',
        'duration_years',
        'semester_1',
        'semester_2',
        'semester_3',
        'semester_4',
        'semester_5',
        'semester_6',
        'semester_7',
        'semester_8',
        'semester_9',
        'semester_10',
        'status',
    ];

    protected $casts = [
        'semester_1' => 'array',
        'semester_2' => 'array',
        'semester_3' => 'array',
        'semester_4' => 'array',
        'semester_5' => 'array',
        'semester_6' => 'array',
        'semester_7' => 'array',
        'semester_8' => 'array',
        'semester_9' => 'array',
        'semester_10' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Course belongs to a department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}