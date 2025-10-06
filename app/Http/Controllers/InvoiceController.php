<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InvoiceManual;
use App\Models\InvoiceManualProduct;
use App\Models\InvoiceManualSubproduct;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $perPage = $request->query('perPage', 10);
        $search = $request->query('search');

        // Bangun query
        $invoices = InvoiceManual::select('*');

        // Tambahkan filter pencarian jika ada
        if ($search) {
            $invoices
                ->where('nama', 'like', '%' . $search . '%')
                ->orWhere('idnumber', 'like', '%' . $search . '%');
        }

        // Paginate dengan query parameter
        $invoices = $invoices->paginate($perPage)->appends([
            'search' => $search,
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

            // 2. Ambil JSON products dari request
            $products = json_decode($request->products, true); // pastikan dikirim sebagai string JSON

            if ($products && is_array($products)) {
                foreach ($products as $p) {
                    // Simpan ke invoice_manual_products
                    $product = InvoiceManualProduct::create([
                        'invoice_manual_id' => $invoice->id,
                        'product_name' => $p['product_name'] ?? null,
                    ]);

                    // 3. Loop items subproducts
                    if (!empty($p['items']) && is_array($p['items'])) {
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
        try {
            // Temukan invoice berdasarkan ID atau gagal
            $invoice = InvoiceManual::findOrFail($id);
            $invoice->delete();

            return redirect()->route('invoice.index')->with('success', 'Invoice berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus invoice: ' . $e->getMessage());
        }
    }

    public function print($num)
    {
        $currentMonth = Carbon::now()->format('Ym');
        $tableName = "NP_{$currentMonth}";
        // $customer = DB::connection('oracle')->table($tableName)
        // ->select('IDNUMBER', 'BPNAME', 'NPWP_TREMS', 'UBIS', 'BISNIS_AREA', 'BUSINESS_SHARE', 'DIVISI', 'WITEL')
        // ->where('idnumber',  $num);
        $invoice = InvoiceManual::select('*')
            ->where('invoice_manuals.id', $num)
            ->firstOrFail();

        $products = InvoiceManualProduct::with('subproducts')
        ->where('invoice_manual_id', $invoice->id)
        ->get();



        // Calculate subtotal from all subproducts and for each product
        $subTotal = 0;
        foreach ($products as $product) {
            $productTotal = $product->subproducts->sum('subproduct_amount');
            $product->total_amount = Number::format($productTotal, 0, locale: 'id_ID');
            $subTotal += $productTotal;
        }

        // Calculate tax from subproducts
        $taxAmount = 0.11; // 11%
        $tax = round($subTotal * $taxAmount);

        // Calculate grand total
        $gtotal = $subTotal + $tax;

        // Spell the number in Indonesian and English words
        $invoice->terbilang = Str::headline(Number::spell($gtotal, locale: 'id_ID'));
        $invoice->spelled = Str::headline(Number::spell($gtotal));

        // Format amount, tax, and grand total in Indonesian Rupiah format without decimal places
        $invoice->subTotal = Number::format($subTotal, 0, locale: 'id_ID');
        $invoice->tax = Number::format($tax, 0, locale: 'id_ID');
        $invoice->grand = Number::format($gtotal, 0, locale: 'id_ID');

        // Payment Status
        $invoice->status = $invoice->payment ? 'Completed Payment' : 'Pending Payment';
        // QrCode data
        $invoice->qrdata = $invoice->nama . "\nNOMOR INVOICE : " . $invoice->nomor_tagihan . "\nAMOUNT : " . $invoice->gtotal;
        // Formatting month
        $invoice->bulan_tagihan = sprintf("%02d", $invoice->bulan_tagihan);

        return view('invoice.print', compact('invoice', 'products'));
    }
}
