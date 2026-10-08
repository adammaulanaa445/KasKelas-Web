<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan kolom diisi
    protected $fillable = ['keterangan', 'tanggal', 'jumlah'];
    protected $table = 'pengeluarans';
}
