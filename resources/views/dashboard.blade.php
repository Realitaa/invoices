@extends('layouts.app')

@section('title', 'Dashboard Transaksi')

@section('content')
<div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Riwayat Transaksi</h1>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4 flex space-x-4">
            <!-- Filter Status -->
            <div>
                <label for="status" class="mr-2">Status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <!-- Filter Pencarian -->
            <div>
                <label for="search" class="mr-2">Cari Pengguna:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="border rounded px-2 py-1" placeholder="Nama pengguna" x-model.debounce.500ms="this.form.submit()">
            </div>

            <!-- Jumlah per Halaman -->
            <div>
                <label for="perPage" class="mr-2">Item per halaman:</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="5" {{ request('perPage', 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('perPage', 10) == 20 ? 'selected' : '' }}>20</option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-sky-200 text-slate-800 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Pengguna</th>
                        <th class="py-3 px-6 text-left">Jumlah</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @foreach ($transactions as $transaction)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $transaction->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $transaction->user->name }}</td>
                            <td class="py-3 px-6 text-left">Rp {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                            <td class="py-3 px-6 text-left">
                                <span class="px-2 py-1 rounded {{ $transaction->status == 'completed' ? 'bg-green-200 text-green-800' : ($transaction->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-left">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $transactions->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection