<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claiming_status extends Model
{
    use HasFactory;

    protected $table = 'claiming_status';

    protected $fillable = [
        'status',
        'created_at',
        'updated_at'
    ];

    public function transaction() {
        return $this->hasOne('transaction');
    }
}
