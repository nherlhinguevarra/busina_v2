<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'vehicle';

    protected $fillable = [
        'vehicle_owner_id',
        'model_color',
        'plate_no',
        'expiry_date',
        'copy_driver_license',
        'copy_cor',
        'copy_school_id',
        'vehicle_type_id',
        'or_no',
        'cr_no',
        'copy_or_cr',
        'created_at',
        'updated_at'
    ];

    public function transaction() {
        return $this->hasMany('transaction');
    }

    public function violation() {
        return $this->hasMany('violation');
    }

    public function vehicle_type() {
        return $this->hasOne('vehicle_type');
    }

    public function vehicle_owner() {
        return $this->hasOne('vehicle_owner');
    }
}
