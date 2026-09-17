<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMaster extends Model
{
    protected $table = 'role_master';

    protected $primaryKey = 'role_id';

    public $timestamps = false;

    protected $fillable = [
        'role_based_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}