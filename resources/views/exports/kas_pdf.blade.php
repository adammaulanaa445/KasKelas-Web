<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kas Kelas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .total { font-weight: bold; margin-top: 15px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KAS KELAS</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
           @foreach($kas as $index => $k)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $k->nama_siswa }}</td>
    <td>{{ $k->tanggal_bayar }}</td>
    <td>Rp {{ number_format($k->jumlah, 0, ',', '.') }}</td>
</tr>
@endforeach
        </tbody>
    </table>

    <div class="total">
        TOTAL KAS: Rp {{ number_format($total_masuk, 0, ',', '.') }}
    </div>
</body>
</html>