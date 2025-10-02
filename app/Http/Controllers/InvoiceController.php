<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InvoiceManual;
use App\Models\InvoiceManualProduct;
use App\Models\InvoiceManualSubproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $invoices = InvoiceManual::select('*');
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
        DB::beginTransaction();
        try {
            // 1. Simpan invoice_manual
            $invoice = InvoiceManual::create([
                'idnumber' => $request->idnumber,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'nomor_tagihan' => $request->nomor_tagihan,
                'npwp' => $request->npwp,
                'tahun_tagihan' => $request->tahun_tagihan,
                'bulan_tagihan' => $request->bulan_tagihan,
                'tanggal_akhir_pembayaran' => $request->tanggal_akhir_pembayaran,
                'tipe_invoice_manual' => $request->tipe_invoice_manual,
                'keterangan_invoice_manual' => $request->keterangan_invoice_manual,
                'nomor_order' => $request->nomor_order,
                'status_order_terakhir' => $request->status_order_terakhir,
            ]);

            // \Log::debug('Decoded products:', json_decode($request->products, true));
            // Output hasil ke log (contoh: dump seluruh objek sebagai array)
        Log::info('Invoice baru dibuat', [
            'invoice_id' => $invoice->id,
            'full_data' => $invoice->toArray(), // Konversi model ke array untuk logging mudah dibaca
        ]);

            // 2. Ambil JSON products dari request
            $products = json_decode($request->products, true); // pastikan dikirim sebagai string JSON

            if ($products && is_array($products)) {
                \Log::debug('Decoded products:', json_decode($request->products, true));
                foreach ($products as $p) {
                    // Simpan ke invoice_manual_products
                    $product = InvoiceManualProduct::create([
                        'invoice_manual_id' => $invoice->id,
                        'product_name' => $p['product_name'] ?? null,
                    ]);

                    // 3. Loop items subproducts
                    if (!empty($p['items']) && is_array($p['items'])) {
                        \Log::debug('Decoded products:', json_decode($request->products, true));
                        foreach ($p['items'] as $sp) {
                            InvoiceManualSubproduct::create([
                                'invoice_manual_product_id' => $product->id,
                                'subproduct_sid' => $sp['product_sid'] ?? null,
                                'subproduct_desc' => $sp['desc'] ?? null,
                                'subproduct_bw' => $sp['bw'] ?? null,
                                'subproduct_period' => $sp['period'] ?? null,
                                'subproduct_amount' => $sp['amount'] ?? null,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('invoice.index')
                ->with('success', 'Invoice manual beserta produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => $e->getMessage()]);
        }
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
        $invoice = InvoiceManual::select('*')
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
