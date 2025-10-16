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
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

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
        $firstDayofMonth = Carbon::now()->startOfMonth();
        return view('invoice.create', compact('firstDayofMonth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input dari form
        $validated = $request->validate([
            'alamat' => 'required|string',
            'nomor_tagihan' => 'required|string|max:255|unique:invoice_manuals,nomor_tagihan',
            'tahun_tagihan' => 'required|numeric|digits:4',
            'bulan_tagihan' => 'required|numeric|between:1,12',
            'tanggal_akhir_pembayaran' => 'required|date',
            'tipe_invoice_manual' => 'required|string|max:255',
            'keterangan_invoice_manual' => 'nullable|string',
            'nomor_order' => 'required|string|max:255',
            'status_order_terakhir' => 'required|string|max:255',
            'tanggal_tanda_tangan' => 'required|date',
            'products' => 'required|json',
        ]);

        // Validasi untuk products JSON
        $products = json_decode($request->products, true);
        // if (empty($products)) {
        //     return back()->withErrors(['products' => 'Minimal harus ada satu produk.'])->withInput();
        // }

        DB::beginTransaction();
        try {
            // 2. Simpan invoice_manual menggunakan data yang sudah divalidasi
            $invoice = InvoiceManual::create([
                'idnumber' => $validated['idnumber'],
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'nomor_tagihan' => $validated['nomor_tagihan'],
                'npwp' => $validated['npwp'],
                'tahun_tagihan' => $validated['tahun_tagihan'],
                'bulan_tagihan' => $validated['bulan_tagihan'],
                'tanggal_akhir_pembayaran' => $validated['tanggal_akhir_pembayaran'],
                'tipe_invoice_manual' => $validated['tipe_invoice_manual'],
                'keterangan_invoice_manual' => $validated['keterangan_invoice_manual'],
                'nomor_order' => $validated['nomor_order'],
                'status_order_terakhir' => $validated['status_order_terakhir'],
                'tanggal_tanda_tangan' => $validated['tanggal_tanda_tangan'],
            ]);

            if ($products && is_array($products)) {
                foreach ($products as $p) {
                    // Simpan ke invoice_manual_products
                    $product = InvoiceManualProduct::create([
                        'invoice_manual_id' => $invoice->id,
                        'product_name' => $p['product_name'] ?? null,
                    ]);

                    // Loop items subproducts
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
        $invoice = InvoiceManual::with(['products.subproducts'])->findOrFail($id);

        // Calculate subtotal from all subproducts and for each product
        $subTotal = 0;
        foreach ($invoice->products as $product) {
            $productTotal = $product->subproducts->sum('subproduct_amount');
            $product->total_amount = Number::format($productTotal, 0, locale: 'id_ID');
            $subTotal += $productTotal;
        }

        // Calculate tax from subproducts
        $taxAmount = 0.11; // 11%
        $tax = round($subTotal * $taxAmount);

        // Calculate grand total
        $gtotal = $subTotal + $tax;

        // Format amount, tax, and grand total in Indonesian Rupiah format without decimal places
        $invoice->subTotal = Number::format($subTotal, 0, locale: 'id_ID');
        $invoice->tax = Number::format($tax, 0, locale: 'id_ID');
        $invoice->grand = Number::format($gtotal, 0, locale: 'id_ID');

        // Payment Status
        $invoice->status = $invoice->payment ? 'Completed Payment' : 'Pending Payment';

        return view('invoice.show', compact('invoice'));
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

    /**
     * Create PDF invoice
     */
    private function createPdf($num)
    {
        $currentMonth = Carbon::now()->format('Ym');
        $tableName = "NP_{$currentMonth}";
        // $customer = DB::connection('oracle')->table($tableName)
        // ->select('IDNUMBER', 'BPNAME', 'NPWP_TREMS', 'UBIS', 'BISNIS_AREA', 'BUSINESS_SHARE', 'DIVISI', 'WITEL')
        // ->where('idnumber',  $num);
        $invoice = InvoiceManual::select('*')
            ->where('id', $num)
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
        $invoice->qrdata = $invoice->nama . "\nINVOICE NO : " . $invoice->nomor_tagihan . "\nAMOUNT : IDR " . $gtotal;
        // Formatting month
        $invoice->bulan_tagihan = sprintf("%02d", $invoice->bulan_tagihan);
        $invoice->bulan_tahun_tagihan = Carbon::create($invoice->tahun_tagihan, $invoice->bulan_tagihan)->locale('id')->translatedFormat('F Y');

        // return view('invoice.document', compact('invoice', 'products'));
        $html = view('invoice.document', compact('invoice', 'products'))->render();
        $pdf = Browsershot::html($html)
            ->setOption('landscape', false)
            ->waitUntilNetworkIdle()
            ->showBackground() // Aktifkan background graphics
            ->pdf();

        // Path file di storage (gunakan $num sebagai nama tetap untuk mudah dicek)
        $filename = "invoice_manual/{$num}/invoice-{$num}.pdf";

        // Simpan ke storage disk 'public'
        Storage::disk('public')->put($filename, $pdf);

        return $filename;
    }

    /**
     * Show preview for invoice
     */
    public function preview($num) {
        $filename = "invoice_manual/{$num}/invoice-{$num}.pdf";
        $sidebar = false;

        // Cek jika file belum ada di storage
        if (!Storage::disk('public')->exists($filename)) {
            $this->createPdf($num); // Buat PDF jika belum ada
        }

        // Dapatkan URL publik untuk preview
        $pdfUrl = Storage::disk('public')->url($filename);

        return view('invoice.preview', compact('pdfUrl'));
    }

    /**
     * Download invoice
     */
    public function download($num)
    {
        $filename = "invoice_manual/{$num}/invoice-{$num}.pdf";

        // Cek jika file belum ada di storage
        if (!Storage::disk('public')->exists($filename)) {
            $this->createPdf($num); // Buat PDF jika belum ada
        }

        // Return response download
        return response()->download(storage_path('app/public/' . $filename), "invoice-{$num}.pdf");
    }
}
