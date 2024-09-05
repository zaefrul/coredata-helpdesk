<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'email'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
