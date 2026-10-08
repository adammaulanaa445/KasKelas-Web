<!DOCTYPE html>
<html>
<head>
    <title>Daftar Bendahara</title>
    <style>
        body { font-family: sans-serif; background: #f2eeee9d; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: white; padding: 20px; rounded-radius: 8px; shadow: 0 2px 10px rgba(0,0,0,0.1); width: 300px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        a { font-size: 12px; color: #666; text-decoration: none; display: block; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align: center">Daftar Akun</h2>
        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Daftar Sekarang</button>
            <a href="{{ route('login') }}">Sudah punya akun? Login</a>
        </form>
    </div>
</body>
</html>