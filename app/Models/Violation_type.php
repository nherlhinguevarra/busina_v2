<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation_type extends Model
{
    use HasFactory;

    protected $table = 'violation_type';

    protected $fillable = [
        'violation_name',
        'penalty_fee'
    ];

    public function violation() {
        return $this->belongsTo('violation');
    }
}
