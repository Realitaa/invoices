<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InvoiceManuals;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil query parameter dari request
        $perPage = $request->query('perPage', 10); // Default 10 item per halaman

        // Bangun query
        $invoices = InvoiceManuals::select('*');
            // ->join('customers', 'invoices.customer_id', '=', 'customers.id');

        // Paginate dengan query parameter
        $invoices = $invoices->paginate($perPage)->appends([
            'perPage' => $perPage,
        ]);

        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'idnumber' => 'nullable|string|max:255',
            'nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'nomor_tagihan' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'tahun_tagihan' => 'nullable|integer',
            'bulan_tagihan' => 'nullable|integer|min:1|max:12',
            'tanggal_akhir_pembayaran' => 'nullable|date',
            'tipe_invoice_manual' => 'nullable|in:PROSES AOSODOMORO,RENEWAL KONTRAK,ADJUSTMENT,BUNDLING,BY REKON/USAGE',
            'keterangan_invoice_manual' => 'nullable|string',
            'nomor_order' => 'nullable|string|max:255',
            'status_order_terakhir' => 'nullable|string|max:255',
            'tanggal_komitmen_penyelesaian' => 'nullable|string|max:255',
        ]);

        // Simpan ke database
        $invoice = InvoiceManuals::create($validated);

        // Response, bisa redirect atau json
        return redirect()->route('invoice.index')
            ->with('success', 'Invoice manual berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function print($num)
    {
        $invoice = Invoice::select('*')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->where('invoices.id', $num)
            ->firstOrFail();

        // Calculate 11% of tax
        $tax = 0.11 * $invoice->amount;
        $invoice->tax = $tax;
        $gtotal = round($invoice->amount + $tax);
        // Spell the number in Indonesian words
        $invoice->terbilang = Str::headline(Number::spell($gtotal, locale: 'id_ID'));
        // Spell the number in English words
        $invoice->spelled = Str::headline(Number::spell($gtotal));
        // Format amount, tax, and grand total in Indonesian Rupiah format without decimal places
        $invoice->grand = Number::format($gtotal, 0, locale: 'id_ID');
        // Format amount in Indonesian Rupiah format without decimal places
        $invoice->amount = Number::format($invoice->amount, 0, locale: 'id_ID');
        // Format tax in Indonesian Rupiah format without decimal places
        $invoice->tax = Number::format($tax, 0, locale: 'id_ID');
        // Payment Status
        $invoice->status = $invoice->payment ? 'Completed Payment' : 'Pending Payment';
        // QrCode data
        $invoice->qrdata = $invoice->name . "\nNOMOR INVOICE : " . $invoice->id . '-' . date('Ymd') . "\nAMOUNT : " . $invoice->amount;

        return view('invoice.print', compact('invoice'));
    }
}
