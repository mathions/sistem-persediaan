<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pemakaian PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2>Data Pemakaian</h2>
    <p><strong>Nama:</strong> {{ $pemakaian->user->name }}</p>
    <p><strong>Deskripsi:</strong> {{ $pemakaian->nama_pemakaian }}</p>
    <p><strong>Status:</strong> {{ $pemakaian->status->nama_status }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Volume</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemakaian->detail_pemakaian as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->referensi->nama_barang }}</td>
                    <td>{{ $item->referensi->satuan->nama_satuan }}</td>
                    <td>{{ $item->volume }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
