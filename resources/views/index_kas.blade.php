<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kas Kelas - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sticky-column {
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 10;
            border-right: 2px solid #e5e7eb;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto px-4 py-10">
        <div class="flex justify-between items-center mb-8">
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm font-semibold shadow-md">
                    🏠 Dashboard Utama
                </a>
                
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('siswa.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm font-semibold shadow-md">
                    👨‍🎓 Kelola Siswa
                </a>

                <a href="{{ route('kas.pdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-semibold shadow-md">
                    <span class="mr-2">📄</span> Cetak Laporan PDF
                </a>
                @endif
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm font-bold">
                    Logout
                </button>
            </form>
        </div>

        <h1 class="text-3xl font-bold text-center text-blue-600 mb-10">💰 Monitoring Kas Kelas</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <div class="lg:col-span-1 space-y-6">
                @if(auth()->user()->role == 'admin')
                    <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-blue-500">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">➕ Tambah Kas</h2>
                        <form action="{{ route('kas.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm text-gray-600 font-medium mb-1">Nama Siswa</label>
                                <select name="nama_siswa" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-white" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswas as $s)
                                        <option value="{{ $s->nama }}">{{ $s->nomor_absen }}. {{ $s->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 font-medium mb-1">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 font-medium mb-1">Jumlah (Rp)</label>
                                <input type="number" name="jumlah" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="5000" required>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">Simpan Kas</button>
                        </form>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-red-500">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">💸 Pengeluaran</h2>
                        <form action="{{ route('pengeluaran.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="keterangan" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 outline-none" placeholder="Keterangan..." required>
                            <input type="date" name="tanggal" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 outline-none" value="{{ date('Y-m-d') }}" required>
                            <input type="number" name="jumlah" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 outline-none" placeholder="Nominal" required>
                            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition shadow-lg">Simpan</button>
                        </form>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 rounded-xl shadow-lg text-white">
                        <h2 class="text-lg font-bold mb-2">👋 Halo, {{ auth()->user()->name }}</h2>
                        <p class="text-xs opacity-90 leading-relaxed">Anda masuk sebagai <b>Siswa</b>. Anda hanya dapat memantau data. Input dan Cetak PDF dinonaktifkan.</p>
                        <div class="mt-4 pt-4 border-t border-blue-400/30">
                            <span class="text-[10px] bg-blue-500 px-2 py-1 rounded-full font-bold uppercase tracking-wider">Mode View-Only</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-3 space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gray-600 p-4 rounded-xl shadow-md text-white">
                        <p class="text-[10px] font-bold uppercase opacity-80">Saldo Pindahan</p>
                        <p class="text-lg font-black">Rp {{ number_format($saldo_awal_bulan ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-600 p-4 rounded-xl shadow-md text-white">
                        <p class="text-[10px] font-bold uppercase opacity-80">Masuk (Bulan Ini)</p>
                        <p class="text-lg font-black">Rp {{ number_format($data_kas->sum('jumlah'), 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-600 p-4 rounded-xl shadow-md text-white">
                        <p class="text-[10px] font-bold uppercase opacity-80">Keluar (Bulan Ini)</p>
                        <p class="text-lg font-black">Rp {{ number_format($data_keluar->sum('jumlah'), 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-blue-800 p-4 rounded-xl shadow-md text-white border-2 border-yellow-400">
                        <p class="text-[10px] font-bold uppercase opacity-80 text-yellow-300">Total Kas Tersedia</p>
                        <p class="text-lg font-black">Rp {{ number_format($saldo_total_saat_ini ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-yellow-500">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">📊 Tren Pemasukan Tahun {{ $tahun }}</h2>
                    <div class="h-[250px]"><canvas id="kasChart"></canvas></div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-md flex flex-col md:flex-row justify-between items-center gap-4">
                    <form action="{{ route('kas.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full">
                        <div class="relative w-full md:w-64">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama..." 
                                class="w-full border rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <span class="absolute left-3 top-2.5">🔍</span>
                        </div>
                        
                        <select name="bulan" onchange="this.form.submit()" class="border rounded-lg px-3 py-2 text-sm outline-none">
                            @for($m=1; $m<=12; $m++)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                        
                        <select name="tahun" onchange="this.form.submit()" class="border rounded-lg px-3 py-2 text-sm outline-none">
                            @for($y=date('Y')-2; $y<=date('Y')+1; $y++)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-blue-700 transition">Filter</button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-green-500">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">🗓️ Matriks Pembayaran</h2>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 sticky-column bg-gray-100 z-20 border-b">Nama Siswa</th>
                                    @for($w=1; $w<=$jumlah_minggu; $w++)
                                        <th class="p-2 text-center border-b border-l min-w-[80px]">M-{{ $w }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $s)
                                <tr class="hover:bg-gray-50 transition border-b">
                                    <td class="p-3 sticky-column font-bold text-gray-700 uppercase">{{ $s->nama }}</td>
                                    @for($w=1; $w<=$jumlah_minggu; $w++)
                                        @php
                                            $tgl_awal = ($w - 1) * 7 + 1;
                                            $tgl_akhir = ($w == $jumlah_minggu) ? 31 : $w * 7;
                                            $bayar = $data_kas->where('nama_siswa', $s->nama)
                                                ->filter(function($item) use ($tgl_awal, $tgl_akhir) {
                                                    $tgl = (int)date('d', strtotime($item->tanggal_bayar));
                                                    return $tgl >= $tgl_awal && $tgl <= $tgl_akhir;
                                                })->first();
                                        @endphp
                                        <td class="p-2 text-center border-l">
                                            @if($bayar)
                                                <div class="w-7 h-7 mx-auto bg-green-500 text-white rounded-lg flex items-center justify-center shadow-sm font-bold">✓</div>
                                            @else
                                                <div class="w-7 h-7 mx-auto bg-gray-100 border border-dashed border-gray-300 rounded-lg"></div>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-blue-400">
                        <h2 class="text-lg font-bold text-gray-700 mb-4">📝 Riwayat (Bulan Ini)</h2>
                        <div class="overflow-y-auto max-h-[400px]">
                            <table class="w-full text-xs text-left border-collapse">
                                <thead class="bg-gray-50 border-b sticky top-0">
                                    <tr>
                                        <th class="p-2">Siswa</th>
                                        <th class="p-2">Tanggal</th>
                                        <th class="p-2">Nominal</th>
                                        <th class="p-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_kas->sortByDesc('tanggal_bayar') as $k)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-2 font-medium uppercase">{{ $k->nama_siswa }}</td>
                                        <td class="p-2">{{ date('d/m/Y', strtotime($k->tanggal_bayar)) }}</td>
                                        <td class="p-2 text-green-600 font-bold">Rp {{ number_format($k->jumlah, 0, ',', '.') }}</td>
                                        <td class="p-2 text-center">
                                            @if(auth()->user()->role == 'admin')
                                                <a href="{{ route('kas.edit', $k->id) }}" class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-[9px] font-bold">EDIT</a>
                                            @else
                                                <span class="text-gray-400 text-[9px]">Read Only</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="p-4 text-center text-gray-400 italic">Kosong</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-orange-500">
                        <h2 class="text-lg font-bold text-gray-700 mb-4">⚠️ Tunggakan (Bulan Ini)</h2>
                        <div class="overflow-y-auto max-h-[400px]">
                            <table class="w-full text-xs text-left border-collapse">
                                <thead class="bg-gray-50 border-b sticky top-0">
                                    <tr>
                                        <th class="p-2">Nama</th>
                                        <th class="p-2">Kurang</th>
                                        <th class="p-2 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswas as $siswa)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-2 font-semibold uppercase">{{ $siswa->nama }}</td>
                                        <td class="p-2 text-red-600 font-bold">
                                            {{ $siswa->tunggakan > 0 ? 'Rp '.number_format($siswa->tunggakan, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="p-2 text-center">
                                            <span class="{{ $siswa->status_kewajiban == 'LUNAS' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2 py-0.5 rounded-full text-[9px] font-black">
                                                {{ $siswa->status_kewajiban }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('kasChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pemasukan (Rp)',
                    data: {!! json_encode($grafik_kas) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { callback: function(value) { return 'Rp ' + value.toLocaleString(); } } 
                    }
                }
            }
        });
    </script>
</body>
</html>