<!DOCTYPE html>
<html>
<head>
    <title>Login Bendahara</title>
    <style>
        body { font-family: sans-serif; background: #ffffffad; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #e27676; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer; }
        a { font-size: 12px; color: #666; text-decoration: none; display: block; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align: center">Login</h2>
        
        @if(session('success'))
            <p style="color: green; font-size: 12px;">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p style="color: red; font-size: 12px;">{{ session('error') }}</p>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
            <a href="{{ route('register') }}">Belum punya akun? Daftar</a>
        </form>
    </div>
</body>
</html>