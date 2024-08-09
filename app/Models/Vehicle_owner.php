<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle_owner extends Model
{
    use HasFactory;

    protected $table = 'vehicle_owner';

    protected $fillable = [
        'fname',
        'lname',
        'mname',
        'contact_no',
        'applicant_type_id',
        'qr_code',
        'emp_id',
        'std_id',
        'driver_license_no',
        'created_at',
        'updated_at'
    ];

    public function user_logs() {
        return $this->hasMany('user_logs');
    }

    public function student() {
        return $this->belongsTo('student');
    }

    public function users() {
        return $this->belongsTo('users');
    }

    public function vehicle() {
        return $this->belongsTo('vehicle');
    }

    public function applicant_type() {
        return $this->hasOne('applicant_type');
    }

    public function employee() {
        return $this->hasOne('employee');
    }
}
