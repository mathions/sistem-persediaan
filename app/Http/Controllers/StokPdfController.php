<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use PDF;

class StokPdfController extends Controller
{
    public function download()
    {
        $stoks = Stok::with('referensi.satuan')->get(); // ambil semua data stok
        $pdf = PDF::loadView('pdf.stok', compact('stoks')); // kirim ke view
        return $pdf->download('laporan-stok.pdf');
    }

}
