<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    // Relasi ke user (note dimiliki oleh user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d M Y');
    }

}
