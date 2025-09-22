@extends('layouts.app')

@section('title', 'Tabel Invoice')

@section('content')
<div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Invoice</h1>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4 flex space-x-4">
            <!-- Filter Status -->
            <!-- <div>
                <label for="status" class="mr-2">Status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div> -->

            <!-- Filter Pencarian -->
            <div>
                <label for="search" class="mr-2">Cari:</label>
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
                        <th class="py-3 px-6 text-left">ID Akun</th>
                        <th class="py-3 px-6 text-left">Nama Akun</th>
                        <th class="py-3 px-6 text-left">Jumlah</th>
                        <th class="py-3 px-6 text-left">Lunas?</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @foreach ($invoices as $invoice)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $invoice->account_id }}</td>
                            <td class="py-3 px-6 text-left">{{ $invoice->name }}</td>
                            <td class="py-3 px-6 text-left">Rp {{ number_format($invoice->amount, 2, ',', '.') }}</td>
                            <td class="py-3 px-6 text-left">
                                <span class="px-2 py-1 rounded {{ $invoice->payment ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $invoice->payment ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <span class="px-2 py-1 rounded {{ $invoice->flagging ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $invoice->flagging ? 'Sudah' : 'Belum' }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <a href="{{ route('invoice.print', ['num' => $invoice->id]) }}" class="text-blue-500 hover:underline cursor-pointer" title="print" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $invoices->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
