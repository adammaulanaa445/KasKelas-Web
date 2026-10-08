<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kas;
use App\Models\Siswa;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class KasController extends Controller
{
    // 1. Menampilkan Halaman Utama Kas (Matriks & Statistik)
    public function index(Request $request)
{
    $bulan = $request->get('bulan', date('m'));
    $tahun = $request->get('tahun', date('Y'));
    $search = $request->get('search');

    // 1. Ambil data Kas & Pengeluaran KHUSUS bulan berjalan (untuk Riwayat & Matriks)
    $data_kas = Kas::whereMonth('tanggal_bayar', $bulan)
                    ->whereYear('tanggal_bayar', $tahun)
                    ->when($search, function($query) use ($search) {
                        $query->where('nama_siswa', 'LIKE', "%{$search}%");
                    })->get();

    $data_keluar = Pengeluaran::whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->get();

    // 2. HITUNG SALDO PINDAHAN (Saldo dari bulan-bulan sebelumnya)
    // Logika: Semua pemasukan sebelum bulan ini dikurangi semua pengeluaran sebelum bulan ini
    $tanggal_awal_bulan_ini = Carbon::create($tahun, $bulan, 1)->startOfMonth();

    $total_masuk_lalu = Kas::where('tanggal_bayar', '<', $tanggal_awal_bulan_ini)->sum('jumlah');
    $total_keluar_lalu = Pengeluaran::where('tanggal', '<', $tanggal_awal_bulan_ini)->sum('jumlah');
    
    $saldo_awal_bulan = $total_masuk_lalu - $total_keluar_lalu;

    // 3. HITUNG TOTAL KAS TERSEDIA (Sampai akhir bulan yang dipilih)
    $tanggal_akhir_bulan_ini = Carbon::create($tahun, $bulan, 1)->endOfMonth();

    $total_masuk_akumulasi = Kas::where('tanggal_bayar', '<=', $tanggal_akhir_bulan_ini)->sum('jumlah');
    $total_keluar_akumulasi = Pengeluaran::where('tanggal', '<=', $tanggal_akhir_bulan_ini)->sum('jumlah');
    
    $saldo_total_saat_ini = $total_masuk_akumulasi - $total_keluar_akumulasi;

    // 4. LOGIKA MATRIKS & MINGGUAN
    $daysInMonth = $tanggal_awal_bulan_ini->daysInMonth;
    $jumlah_minggu = ceil($daysInMonth / 7);

    // 5. STATUS TUNGGAKAN SISWA
    $nominalWajibBulan = 20000; 
    $siswas = Siswa::orderBy('nomor_absen', 'asc')->get();

    foreach ($siswas as $siswa) {
        $totalBayarBulanIni = $data_kas->where('nama_siswa', $siswa->nama)->sum('jumlah');
        $siswa->total_bayar = $totalBayarBulanIni;
        $siswa->tunggakan = $nominalWajibBulan - $totalBayarBulanIni;
        $siswa->status_kewajiban = ($siswa->tunggakan <= 0) ? 'LUNAS' : 'NUNGGAK';
    }

    // 6. DATA GRAFIK (Tetap 12 bulan untuk tahun yang dipilih)
    $grafik_kas = [];
    for ($m = 1; $m <= 12; $m++) {
        $grafik_kas[] = Kas::whereMonth('tanggal_bayar', $m)
                          ->whereYear('tanggal_bayar', $tahun)
                          ->sum('jumlah');
    }

    // Mengirim variabel ke view
    return view('index_kas', compact(
        'data_kas', 
        'data_keluar', 
        'siswas', 
        'jumlah_minggu', 
        'bulan', 
        'tahun', 
        'nominalWajibBulan', 
        'grafik_kas', 
        'saldo_awal_bulan',      // Saldo dari bulan sebelumnya
        'saldo_total_saat_ini',  // Total uang kas yang ada di dompet/rekening
        'search'
    ));

    }

    /**
     * 2. FUNGSI SIMPAN KAS (INI YANG TADI HILANG)
     * Fungsi ini dipanggil oleh Route::post('/kas/simpan', ...)->name('kas.store')
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa'    => 'required',
            'jumlah'        => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
        ]);

        Kas::create([
            'nama_siswa'    => $request->nama_siswa,
            'jumlah'        => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
        ]);

        if (auth()->user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Maaf, hanya bendahara yang boleh menambah data!');
        if (auth()->user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengunduh laporan!');
    }
    }

        return redirect()->route('kas.index')->with('success', 'Pembayaran kas berhasil disimpan!');
    }

    // 3. Simpan Pengeluaran (Jika kamu memanggilnya secara khusus)
    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric',
        ]);

        Pengeluaran::create([
            'keterangan' => $request->keterangan,
            'tanggal'    => $request->tanggal,
            'jumlah'     => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat!'); 
    }

    // 4. Edit Data Kas
    public function edit($id)
    {
        $kas = Kas::findOrFail($id);
        $siswas = Siswa::all(); 
        return view('edit_kas', compact('kas', 'siswas'));
    }

    // 5. Update Data Kas
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
        ]);

        $kas = Kas::findOrFail($id);
        $kas->update($request->only(['tanggal_bayar', 'jumlah']));

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil diperbarui!');
    }

    // 6. Hapus Data Kas
    public function destroy($id)
    {
        $kas = Kas::findOrFail($id);
        $kas->delete();

        return redirect()->route('kas.index')->with('success', 'Data transaksi berhasil dihapus');
    }

    public function exportPDF()
{
    // Mengambil semua data kas
    $kas = Kas::all(); 
    
    // Hitung total saldo untuk ditampilkan di PDF
    $total_masuk = Kas::sum('jumlah');

    // Memanggil view khusus untuk desain PDF
    $pdf = Pdf::loadView('exports.kas_pdf', compact('kas', 'total_masuk'));

    // Menentukan nama file saat didownload
    return $pdf->download('Laporan-Kas-Kelas.pdf');
}
}