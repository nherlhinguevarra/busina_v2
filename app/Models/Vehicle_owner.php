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
        return $this->hasMany(User_logs::class, 'vehicle_owner_id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'std_no');
    }

    public function users() {
        return $this->belongsTo(Users::class, 'vehicle_owner_id');
    }

    public function vehicle() {
        return $this->hasMany(Vehicle::class, 'vehicle_owner_id');
    }

    public function applicant_type() {
        return $this->belongsTo(Applicant_type::class, 'applicant_type_id');
    }

    public function employee() {
        return $this->hasOne(Employee::class, 'emp_id');
    }
}
