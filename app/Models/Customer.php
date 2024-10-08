<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    public function departments()
    {
        return $this->hasMany(Department::class)->withTrashed();
    }

    public function users()
    {
        return $this->hasMany(User::class)->withTrashed();
    }
}
