<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';

    protected $fillable = [
        'fname',
        'lname',
        'mname',
        'std_no',
        'created_at',
        'updated_at'
    ];

    public function vehicle_owner() {
        return $this->hasMany('vehicle_owner');
    }
}
