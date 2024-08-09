<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_resets extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    protected $fillable = [
        'emp_no',
        'reset_token',
        'used_reset_token',
        'expiration',
        'created_at',
    ];

    public function users() {
        return $this->belongsTo('users');
    }
}
