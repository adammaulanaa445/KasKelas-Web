<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama - Kas Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white   -100 h-screen flex items-center justify-center font-sans">
    <div class="max-w-4xl w-full px-6">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-slate-800 mb-3">Selamat Datang! 👋</h1>
            <p class="text-slate-600 text-lg">Pilih menu untuk mulai mengelola data kelas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <a href="{{ route('siswa.index') }}" class="group bg-white p-10 rounded-3xl shadow-md hover:shadow-xl transition-all border-b-8 border-emerald-500 text-center">
                <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">👨‍🎓</div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Siswa</h2>
                <p class="text-slate-500 mt-2">Input nama & nomor absen.</p>
                <p class="text-slate-500 mt-2">Digunakan untuk menambahkan data siswa serta mengelola data siswa.</p>
            </a>

            <a href="{{ route('kas.index') }}" class="group bg-white p-10 rounded-3xl shadow-md hover:shadow-xl transition-all border-b-8 border-indigo-500 text-center">
                <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">💰</div>
                <h2 class="text-2xl font-bold text-slate-800">Uang Kas</h2>
                <p class="text-slate-500 mt-2">Catat pemasukan & riwayat.</p>
                <p class="text-slate-500 mt-2">Digunakan untuk mencatat pemasukan dan pengeluaran uang kas serta melihat riwayat transaksi.</p>
            </a>
        </div>

        <div class="mt-16 text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-slate-200 hover:bg-red-100 hover:text-red-600 text-slate-600 px-6 py-2 rounded-full font-semibold transition-colors">
                    Logout (Keluar)
                </button>
            </form>
        </div>
    </div>
</body>
</html>