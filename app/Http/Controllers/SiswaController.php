<?php
namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() {
        $data_siswa = Siswa::orderBy('nomor_absen', 'asc')->get();
        return view('index_siswa', compact('data_siswa'));
    }

    public function destroy($id)
{
    Siswa::destroy($id);
    return redirect()->back()->with('success', 'Siswa dihapus!');
}

    public function update(Request $request, $id)
{
    $request->validate(['nomor_absen' => 'required', 'nama' => 'required']);
    
    $siswa = Siswa::findOrFail($id);
    $siswa->update($request->all());
    
    return redirect()->back()->with('success', 'Data diperbarui!');
}

    public function store(Request $request) {
        // Validasi sederhana agar tidak error jika input kosong
        $request->validate([
            'nama' => 'required',
            'nomor_absen' => 'required|numeric',
        ]);

        Siswa::create([
            'nama' => $request->nama,
            'nomor_absen' => $request->nomor_absen,
        ]);

        return redirect()->route('siswa.index');
    }
}
