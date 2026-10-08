<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border-t-8 border-blue-600">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">🚀 Setup Ruang Kas Anda</h2>
    
    <form action="{{ route('save.profile') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-600">Negara</label>
                <input type="text" name="negara" class="w-full border p-2 rounded-lg" placeholder="Indonesia" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-600">Daerah/Kota</label>
                <input type="text" name="daerah" class="w-full border p-2 rounded-lg" placeholder="Jakarta" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600">Kategori Instansi</label>
            <select name="kategori" id="kategori" onchange="toggleJenjang()" class="w-full border p-2 rounded-lg">
                <option value="pekerjaan">Kantor / Pekerjaan</option>
                <option value="sekolah">Sekolah / Pendidikan</option>
            </select>
        </div>

        <div id="jenjang-div" class="hidden">
            <label class="block text-sm font-bold text-gray-600">Jenjang</label>
            <select name="sub_kategori" class="w-full border p-2 rounded-lg">
                <option value="sd">SD</option>
                <option value="smp">SMP</option>
                <option value="sma">SMA/SMK</option>
                <option value="kuliah">Universitas</option>
            </select>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <label class="block text-sm font-bold text-blue-700">🔐 Password Akses Teman/Siswa</label>
            <p class="text-xs text-blue-500 mb-2">Berikan password ini ke teman kelas agar mereka bisa login melihat kas.</p>
            <input type="text" name="visitor_password" class="w-full border-2 border-blue-300 p-2 rounded-lg focus:ring-blue-500" placeholder="Contoh: masuk-kelas-7a" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
            Selesaikan Pendaftaran & Buka Kas
        </button>
    </form>
</div>

<script>
    function toggleJenjang() {
        const kat = document.getElementById('kategori').value;
        document.getElementById('jenjang-div').classList.toggle('hidden', kat !== 'sekolah');
    }
</script>