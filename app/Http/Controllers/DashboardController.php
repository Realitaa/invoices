<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query parameter dari request
        $perPage = $request->query('perPage', 10); // Default 10 item per halaman
        $status = $request->query('status'); // Filter status
        $search = $request->query('search'); // Filter pencarian (opsional)

        // Bangun query
        $query = Transaction::with('user')->latest();

        // Terapkan filter berdasarkan status jika ada
        if ($status) {
            $query->where('status', $status);
        }

        // Terapkan filter pencarian jika ada
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Paginate dengan query parameter
        $transactions = $query->paginate($perPage)->appends([
            'perPage' => $perPage,
            'status' => $status,
            'search' => $search,
        ]);

        if ($request->ajax()) {
            return response()->json($transactions);
        }

        return view('dashboard', compact('transactions'));
    }
}
