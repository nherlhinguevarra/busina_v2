<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorized_user extends Model
{
    use HasFactory;

    protected $table = 'authorized_user';

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

    protected $primaryKey = 'id';

    // Accessor to get the full name
    public function getFullNameAttribute()
    {
        return trim("{$this->fname} {$this->mname} {$this->lname}");
    }
    
    public function violation() {
        return $this->hasMany(Violation::class, 'reported_by');
    }

    public function users() {
        return $this->hasOne('users');
    }

    public function user_type() {
        return $this->belongsTo('user_type');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
