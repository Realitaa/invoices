<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Tentukan nama tabel berdasarkan tahun dan bulan saat ini
        $currentMonth = Carbon::now()->format('Ym'); // Misal: 202509
        $tableName = "NP_{$currentMonth}";

        try {
            // Cek apakah tabel ada
            if (Schema::hasTable($tableName)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Tabel {$tableName} tidak ditemukan."
                ], 404);
            }

            // Ambil parameter per_page dari query string, default 10
            $perPage = $request->query('per_page', 10);

            // Validasi per_page agar berupa angka positif
            if (!is_numeric($perPage) || $perPage < 1) {
                $perPage = 10;
            }

            // Ambil data unik berdasarkan IDNUMBER dengan paginasi
            $customers = DB::connection('oracle')->table($tableName)
                ->select('IDNUMBER', 'BPNAME', 'NPWP_TREMS', 'UBIS', 'BISNIS_AREA', 'BUSINESS_SHARE', 'DIVISI', 'WITEL')
                ->distinct('IDNUMBER') // Ambil data unik berdasarkan IDNUMBER
                ->paginate($perPage);

            return view('customer.index', compact('customers'));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // // Validasi input
        // $request->validate([
        //     'id' => 'required|unique:customers,id',
        //     'name' => 'required|string|max:255',
        //     'npwp' => 'required|string|max:255',
        //     'address' => 'required|string',
        // ]);

        // // Simpan data customer baru
        // $customer = new Customer();
        // $customer->id = $request->input('id');
        // $customer->name = $request->input('name');
        // $customer->npwp = $request->input('npwp');
        // $customer->address = $request->input('address');
        // $customer->save();

        // return redirect()->route('customer.index')->with('success', 'Customer berhasil disimpan.');
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

    /**
     * Fetch customers based on query parameters and return as JSON.
     */
    public function fetch(Request $request)
    {
        // Ambil query parameter dari request
        $search = $request->query('query', '');

        // Tentukan nama tabel berdasarkan tahun dan bulan saat ini
        $currentMonth = Carbon::now()->format('Ym'); // Misal: 202509
        $tableName = "NP_{$currentMonth}";

        // Bangun query

        if (!empty($search)) {
            $query = DB::connection('oracle')->table($tableName)
            ->select('IDNUMBER', 'BPNAME')
            ->distinct()
            ->whereRaw("BPNAME LIKE '%" . strtoupper($search) . "%' OR IDNUMBER LIKE '%" . strtoupper($search) . "%'");
        }

        // Ambil maksimal 10 data
        $customers = $query->limit(10)->get();

        // Kembalikan hasil dalam bentuk JSON
        return response()->json($customers);
    }
}
