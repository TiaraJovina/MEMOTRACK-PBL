<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'user_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi: Jadwal dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope: Hanya jadwal yang akan datang
    public function scopeUpcoming(Builder $query)
    {
        return $query->where('scheduled_at', '>=', now());
    }

    // Scope: Hanya jadwal yang sudah lewat
    public function scopePast(Builder $query)
    {
        return $query->where('scheduled_at', '<', now());
    }
}
