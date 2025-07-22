<?php

namespace App\Http\Controllers;

use App\Models\RekapUsulan;
use PDF;

class RekapUsulanPdfController extends Controller
{
    public function download()
    {
        $rekap_usulans = RekapUsulan::with('referensi.satuan')->get(); // ambil semua data stok
        $pdf = PDF::loadView('pdf.rekapusulan', compact('rekap_usulans')); // kirim ke view
        return $pdf->download('rekap-usulan.pdf');
    }

}
