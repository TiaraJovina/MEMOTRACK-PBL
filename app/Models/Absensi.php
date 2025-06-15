<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = "absensi";
    protected $fillable = [
        'title',
        'details',
        'date',
        'role',
        'user_id'
    ]; 
}
