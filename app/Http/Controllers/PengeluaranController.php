<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;

class PengeluaranController extends Controller
{
    // Menyimpan pengeluaran baru
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        Pengeluaran::create([
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat!');
    }

    // Menampilkan halaman edit pengeluaran
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('edit_pengeluaran', compact('pengeluaran'));
    }

    // Mengupdate data pengeluaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($request->all());

        return redirect()->route('kas.index')->with('success', 'Data pengeluaran diperbarui!');
    }

    // Menghapus pengeluaran
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('kas.index')->with('success', 'Data pengeluaran dihapus!');
    }
}