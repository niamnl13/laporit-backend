<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'operator_id',
        'judul',
        'nub',
        'jenis_kerusakan',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'priority',
        'tgl_eksekusi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}