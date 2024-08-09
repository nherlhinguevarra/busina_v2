<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_logs extends Model
{
    use HasFactory;

    protected $table = 'user_logs';

    protected $fillable = [
        'vehicle_owner_id',
        'log_date',
        'time_in',
        'time_out',
    ];

    public function vehicle_owner() {
        return $this->hasOne('vehicle_owner');
    }
}
