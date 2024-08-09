<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    use HasFactory; 

    protected $table = 'user_type';

    protected $fillable = [
        'user_type_name',
    ];

    public function authorized_user() {
        return $this->hasOne('authorized_user');
    }
}
