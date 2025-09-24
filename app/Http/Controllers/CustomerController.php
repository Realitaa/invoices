<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil query parameter dari request
        $perPage = $request->query('perPage', 10); // Default 10 item per halaman

        // Bangun query
        $customers = Customer::select('*');

        // Paginate dengan query parameter
        $customers = $customers->paginate($perPage)->appends([
            'perPage' => $perPage,
        ]);

        return view('customer.index', compact('customers'));
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

        // Bangun query
        $query = Customer::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('npwp', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
        }

        // Ambil maksimal 10 data
        $customers = $query->limit(10)->get();

        // Kembalikan hasil dalam bentuk JSON
        return response()->json($customers);
    }
}
