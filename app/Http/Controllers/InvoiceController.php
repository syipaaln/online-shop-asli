<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Pembelian; // Sesuaikan dengan model Anda

class InvoiceController extends Controller
{
    public function generateInvoice($pembelianId)
    {
        $pembelian = Pembelian::findOrFail($pembelianId);
        $pdf = PDF::loadView('invoice', compact('pembelian'));
        return $pdf->download('invoice.pdf');
    }
}