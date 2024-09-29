<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    public function notifications()
    {
        return $this->hasMany(CustomerNotification::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
