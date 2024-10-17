<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewViolationNotif;
use Illuminate\Support\Facades\Notification;

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
        return $this->belongsTo(Violation_type::class, 'violation_type_id');
    }

    public function settle_violation() {
        return $this->hasOne(Settle_violation::class, 'violation_id');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function authorized_user() {
        return $this->belongsTo(Authorized_user::class, 'reported_by');
    }

    protected static function booted() {
        static::created(function ($violation) {
            Notification::route('broadcast', '')
                ->notify(new NewViolationNotif($violation));
        });
    }
}
