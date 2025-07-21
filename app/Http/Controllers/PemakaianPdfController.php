<?php

namespace App\Http\Controllers;

use App\Models\Pemakaian;
use PDF;

class PemakaianPdfController extends Controller
{
    public function download(Pemakaian $pemakaian)
    {
        $pdf = PDF::loadView('pdf.pemakaian', compact('pemakaian'));
        return $pdf->download('pemakaian-' . $pemakaian->id . '.pdf');
    }
}
