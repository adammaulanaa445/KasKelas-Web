<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Ini sangat penting agar data bisa disimpan!
    protected $fillable = ['nama', 'nomor_absen'];
}
