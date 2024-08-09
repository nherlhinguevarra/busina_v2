<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'vehicle_id',
        'reference_no',
        'registration_no',
        'emp_id',
        'claiming_status_id',
        'apply_date',
        'issued_date',
        'created_at',
        'updated_at',
        'vehicle_status',
        'sticker_expiry',
        'amount_payable',
        'transac_type'
    ];

    public function vehicle() {
        return $this->hasOne('vehicle');
    }

    public function claiming_status() {
        return $this->hasOne('claiming_status');
    }

    public function employee() {
        return $this->hasOne('employee');
    }
}
