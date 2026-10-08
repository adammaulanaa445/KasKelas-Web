<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center font-sans">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border-t-8 border-red-500">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">💸 Edit Pengeluaran</h2>
        <p class="text-center text-gray-500 text-sm mb-6">Ubah data pengeluaran kas kelas.</p>
        
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                <input type="text" name="keterangan" value="{{ $pengeluaran->keterangan }}" 
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring-2 focus:ring-red-400 outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $pengeluaran->tanggal }}" 
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring-2 focus:ring-red-400 outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nominal (Rp)</label>
                <input type="number" name="jumlah" value="{{ $pengeluaran->jumlah }}" 
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring-2 focus:ring-red-400 outline-none" required>
            </div>

            <div class="flex flex-col gap-2 pt-4">
                <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg font-bold hover:bg-red-700 transition shadow">Simpan Perubahan</button>
            </div>
        </form>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center"><span class="w-full border-t"></span></div>
            <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400">Atau</span></div>
        </div>

        <div class="flex flex-col gap-2">
            <form action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST" onsubmit="return confirm('Hapus data pengeluaran ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-white border border-red-500 text-red-500 py-2 rounded-lg font-bold hover:bg-red-50 transition">🗑️ Hapus</button>
            </form>
            
            <a href="{{ route('kas.index') }}" class="w-full bg-gray-200 text-gray-700 py-2 rounded-lg font-bold text-center hover:bg-gray-300 transition">Batal</a>
        </div>
    </div>

</body>
</html>