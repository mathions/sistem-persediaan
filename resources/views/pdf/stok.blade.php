<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang Persediaan</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            margin: 40px;
        }
        h2 {
            text-align: center;
            text-transform: uppercase;
            height: 40px;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
        }
        th {
            text-align: center;
        }
        td.center {
            text-align: center;
        }
        td.right {
            text-align: right;
        }
        .signature-section {
            margin-top: 8px;
        }
        .signature-table {
            width: 100%;
            border: none;
            margin-top: 30px;
        }
        .signature-table td {
            border: none;
            text-align: center;
            vertical-align: top;
            height: 48px;
        }
    </style>
</head>
<body>

    <h2>LAPORAN STOK BARANG PERSEDIAAN</h2>

    <p>
        Pada hari ini, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} stok barang persediaan 
        di BPS Kabupaten Nias Utara adalah sebagai berikut:
    </p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 30%;">Uraian Barang</th>
                <th style="width: 10%;">Satuan</th>
                <th style="width: 20%;">Harga Beli Satuan (Rupiah)</th>
                <th style="width: 10%;">Volume</th>
                <th style="width: 20%;">Harga Total (Rupiah)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stoks as $i => $stok)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $stok->referensi->nama_barang }}</td>
                    <td class="center">{{ $stok->referensi->satuan->nama_satuan }}</td>
                    <td class="right">{{ number_format($stok->harga_beli, 0, ',', '.') }}</td>
                    <td class="center">{{ $stok->volume }}</td>
                    <td class="right">{{ number_format($stok->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
            <tfoot>
        <tr>
            <td colspan="5" class="center"><strong>Total</strong></td>
            <td class="right">
                <strong>
                    {{ number_format($stoks->sum('total'), 0, ',', '.') }}
                </strong>
            </td>
        </tr>
    </tfoot>
    </table>

    <div class="signature-section">
        <p style="text-align: right; margin-right: 40px;"></p>

        <table class="signature-table">
            <tr>
                <td>Mengetahui,<br>Kepala BPS Kabupaten Nias Utara</td>
                <td>Lotu, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br> Petugas Pengelola Persediaan</td>
            </tr>
            <tr>
                <td style="height: 40px;"></td>
                <td></td>
            </tr>
            <tr>
                <td>Darma Beriman Telaumbanua, SE, MM</td>
                <td>Supriadi Hia, SST, M.Stat.</td>
            </tr>
        </table>
    </div>

</body>
</html>
