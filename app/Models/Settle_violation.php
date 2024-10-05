<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settle_violation extends Model
{
    use HasFactory;

    protected $table = 'settle_violation';

    protected $fillable = [
        'violation_id',
        'document',
        'created_at',
        'updated_at'
    ];

    public function violation() {
        return $this->hasOne('violation');
    }
}
