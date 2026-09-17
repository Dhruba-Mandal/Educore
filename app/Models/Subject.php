<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $primaryKey = 'subject_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'subject_name',
        'subject_code',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'department_subject',
            'subject_id',
            'department_id',
            'subject_id',
            'id'
        );
    }
}