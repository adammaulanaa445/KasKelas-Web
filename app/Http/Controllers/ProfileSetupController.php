<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileSetupController extends Controller
{
    public function store(Request $request) {
    $user = auth()->user();
    
    $user->update([
        'negara' => $request->negara,
        'daerah' => $request->daerah,
        'kategori' => $request->kategori,
        'sub_kategori' => $request->sub_kategori,
        'visitor_password' => $request->visitor_password,
        'expired_at' => now()->addYears(2), // Set masa aktif 2 tahun
        'role' => 'admin' // Pendaftar otomatis jadi admin di grupnya
    ]);

    return redirect()->route('dashboard')->with('success', 'Ruang Kas berhasil dibuat!');
}
}
