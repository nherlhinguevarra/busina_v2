<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [
        'fname',
        'lname',
        'mname',
        'emp_no',
        'department',
        'position',
        'privilege',
        'created_at',
        'updated_at'
    ];

    public function transaction() {
        return $this->hasMany('transaction');
    }

    public function authorized_user() {
        return $this->hasOne('authorized_users');
    }

    public function vehicle_owner() {
        return $this->belongsTo('vehicle_owner');
    }
}
