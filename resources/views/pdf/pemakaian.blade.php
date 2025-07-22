<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulir Pemakaian</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            margin: 40px;
        }
        .center-title {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60px;
            margin-bottom: 12px;
        }
        h2 {
            text-align: center;
            text-transform: uppercase;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
        }
    </style>
</head>
<body>

    <div class="center-title">
        <h2>PERMINTAAN ATK/ARK/PUBLIKASI/CETAKAN</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 60%;">Nama Barang</th>
                <th style="width: 20%;">Satuan</th>
                <th style="width: 20%;">Volume</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemakaian->detail_pemakaian as $i => $item)
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td>{{ $item->referensi->nama_barang }}</td>
                    <td style="text-align: center;">{{ $item->volume }}</td>
                    <td style="text-align: center;">{{ $item->referensi->satuan->nama_satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 40px;">
        <table style="width:100%; text-align: center; border: none; border-collapse: collapse;">
            <tr style="border: none;">
                <td style="width: 50%; border: none;">
                    Mengetahui,<br>Kasubbag Umum <br> BPS Kabupaten Nias Utara<br><br><br><br><br><br>
                    <strong>Karya Jaya Zendrato, S.ST., M.SE</strong><br>
                    NIP. 1992199219919119
                </td>
                <td style="width: 50%; border: none;">
                    <br>Lotu, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    Penerima Barang<br><br><br><br><br><br>
                    <strong>{{ $pemakaian->user->name }}</strong><br>
                    NIP. 2001123012301230
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
