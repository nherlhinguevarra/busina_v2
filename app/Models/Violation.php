<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $table = 'violation';

    protected $fillable = [
        'plate_no',
        'location',
        'violation_type_d',
        'proof_image',
        'reported_by',
        'vehicle_id',
        'created_at',
        'updated_at'
    ];

    public function violation_type() {
        return $this->hasOne('violation_type');
    }

    public function settle_violation() {
        return $this->hasOne('settle_violation');
    }

    public function vehicle() {
        return $this->hasOne('vehicle');
    }

    public function authorized_user() {
        return $this->hasOne('authorized_user');
    }
}
