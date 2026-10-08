<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Siswa</title>
</head>
<body class="bg-gray-100 p-10">

    <div class="container mx-auto">
        <div class="flex justify-between mb-6">
             <h1 class="text-2xl font-bold text-blue-600">👨‍🎓 Daftar Siswa Kelas</h1>
             <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow transition">🏠 Dashboard</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-xl shadow-md h-fit border-t-4 border-blue-500">
                @if(auth()->user()->role == 'admin')
                    <h2 id="form-title" class="text-lg font-bold mb-4 text-gray-700">Tambah Siswa</h2>
                    
                    <form id="siswa-form" action="{{ route('siswa.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div id="method-field"></div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">No Absen</label>
                            <input type="number" name="nomor_absen" id="nomor_absen" placeholder="Contoh: 1" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Siswa</label>
                            <input type="text" name="nama" id="nama" placeholder="Nama Lengkap" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <button type="submit" id="submit-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-bold transition shadow">Simpan Siswa</button>
                            <button type="button" id="cancel-btn" onclick="resetForm()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded font-bold text-center transition hidden">Batal Edit</button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-4">
                        <div class="text-4xl mb-3">🛡️</div>
                        <h2 class="font-bold text-gray-800">Mode View-Only</h2>
                        <p class="text-xs text-gray-500 mt-2 leading-relaxed">Anda hanya dapat melihat daftar siswa. Izin tambah, edit, dan hapus hanya dimiliki oleh Bendahara.</p>
                    </div>
                @endif
            </div>

            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-md border-t-4 border-emerald-500">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3 text-gray-600 font-bold uppercase text-xs w-20">No Absen</th>
                                <th class="p-3 text-gray-600 font-bold uppercase text-xs">Nama</th>
                                @if(auth()->user()->role == 'admin')
                                    <th class="p-3 text-gray-600 font-bold uppercase text-xs text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_siswa as $s)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-3 text-gray-700">{{ $s->nomor_absen }}</td>
                                <td class="p-3 font-bold text-gray-800 uppercase">{{ $s->nama }}</td>
                                
                                @if(auth()->user()->role == 'admin')
                                <td class="p-3 flex justify-center gap-2">
                                    <button onclick="prepareEdit('{{ $s->id }}', '{{ $s->nomor_absen }}', '{{ $s->nama }}')" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs font-bold shadow transition">
                                        Edit
                                    </button>

                                    <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini dari daftar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold shadow transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role == 'admin')
    <script>
        function prepareEdit(id, absen, nama) {
            const form = document.getElementById('siswa-form');
            const title = document.getElementById('form-title');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const methodField = document.getElementById('method-field');

            form.action = `/siswa/${id}`; 
            methodField.innerHTML = `@method('PUT')`;

            document.getElementById('nomor_absen').value = absen;
            document.getElementById('nama').value = nama;

            title.innerText = "Edit Data Siswa";
            title.classList.replace('text-gray-700', 'text-yellow-600');
            submitBtn.innerText = "Perbarui Data";
            submitBtn.classList.replace('bg-blue-600', 'bg-yellow-500');
            submitBtn.classList.replace('hover:bg-blue-700', 'hover:bg-yellow-600');
            cancelBtn.classList.remove('hidden');
        }

        function resetForm() {
            const form = document.getElementById('siswa-form');
            const title = document.getElementById('form-title');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const methodField = document.getElementById('method-field');

            form.action = "{{ route('siswa.store') }}";
            methodField.innerHTML = "";
            form.reset();

            title.innerText = "Tambah Siswa";
            title.classList.replace('text-yellow-600', 'text-gray-700');
            submitBtn.innerText = "Simpan Siswa";
            submitBtn.classList.replace('bg-yellow-500', 'bg-blue-600');
            submitBtn.classList.replace('hover:bg-yellow-600', 'hover:bg-blue-700');
            cancelBtn.classList.add('hidden');
        }
    </script>
    @endif
</body>
</html>