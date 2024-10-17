<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewVehicleNotif;
use Illuminate\Support\Facades\Notification;

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
        return $this->hasMany(Transaction::class, 'vehicle_id');
    }

    public function violation() {
        return $this->hasMany(Violation::class, 'vehicle_id');
    }

    public function vehicle_type() {
        return $this->belongsTo(Vehicle_type::class, 'vehicle_type_id');
    }

    public function vehicle_owner() {
        return $this->belongsTo(Vehicle_owner::class, 'vehicle_owner_id', 'id');
    }

    protected static function booted () {
        static::created(function ($vehicle) {
            Notification::route('broadcast', '')
                ->notify(new NewVehicleNotif($vehicle));
        });
    }
}
