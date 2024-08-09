<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unauthorized extends Model
{
    use HasFactory;

    protected $table = 'unauthorzied';

    protected $fillable = [
        'plate_no',
        'fullname',
        'purpose',
        'created_at',
        'updated_at'
    ];
}
