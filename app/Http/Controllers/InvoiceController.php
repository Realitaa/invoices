<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

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
        $invoices = Invoice::select('invoices.id', 'invoices.account_id', 'accounts.name', 'invoices.amount', 'invoices.payment', 'invoices.flagging')
            ->join('accounts', 'invoices.account_id', '=', 'accounts.id');

        // Paginate dengan query parameter
        $invoices = $invoices->paginate($perPage)->appends([
            'perPage' => $perPage,
        ]);

        return view('invoice', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $invoice = Invoice::where('id', $num)->firstOrFail();
        return view('print', compact('invoice'));
    }
}
