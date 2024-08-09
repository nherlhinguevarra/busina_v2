<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorized_user extends Model
{
    use HasFactory;

    protected $table = 'authorzied_user';

    protected $fillable = [
        'fname',
        'lname',
        'mname',
        'contact_no',
        'user_type',
        'emp_id',
        'created_at',
        'updated_at'
    ];

    public function violation() {
        return $this->hasMany('violation');
    }

    public function users() {
        return $this->hasOne('users');
    }

    public function user_type() {
        return $this->belongsTo('user_type');
    }

    public function employee() {
        return $this->hasOne('employee');
    }
}
