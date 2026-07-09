<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['code', 'name'];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'department_id');
    }
}
