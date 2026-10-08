<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class Faculty extends Model
{
    protected $fillable = [
        'faculty_id',
        'name',
        'department_id',
        'designation',
        'experience_years',
        'email',
        'phone_no',
        'password',
        'status',
        'created_by',
        'updated_by',
    ];
    public $timestamps = false;

    protected $casts = [
        'experience_years' => 'integer',
        'status' => 'boolean',
        'password' => 'hashed',
    ];                                   

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class,
            'department_id'
        );
    }
}