<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kas - {{ $kas->nama_siswa }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center font-sans">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border-t-8 border-yellow-500">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">✏️ Edit Data Kas</h2>
        <p class="text-center text-gray-500 text-sm mb-6">Pastikan data sudah sesuai sebelum disimpan.</p>
        
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kas.update', $kas->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                <input type="text" value="{{ $kas->nama_siswa }}" 
                    class="w-full border bg-gray-100 rounded-lg px-4 py-2 mt-1 text-gray-400 cursor-not-allowed outline-none" readonly>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" value="{{ $kas->tanggal_bayar }}" 
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nominal (Rp)</label>
                <input type="number" name="jumlah" value="{{ $kas->jumlah }}" 
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none" required>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-lg font-bold hover:bg-yellow-600 transition shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center"><span class="w-full border-t"></span></div>
            <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400">Tindakan Lain</span></div>
        </div>

        <div class="flex flex-col gap-2">
            <form action="{{ route('kas.destroy', $kas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-white border border-red-500 text-red-500 py-2 rounded-lg font-bold hover:bg-red-50 transition">
                    🗑️ Hapus Transaksi
                </button>
            </form>
            
            <a href="{{ route('kas.index') }}" class="w-full bg-gray-200 text-gray-700 py-2 rounded-lg font-bold text-center hover:bg-gray-300 transition">
                Batal / Kembali
            </a>
        </div>
    </div>

</body>
</html>