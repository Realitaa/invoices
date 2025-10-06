@extends('layouts.app')

@section('title', 'Tabel Invoice')

@section('content')
<div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Invoice</h1>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('invoice.index') }}" class="mb-4 flex space-x-4 items-center">
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
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="border rounded px-2 py-1" placeholder="Nama akun" x-model.debounce.500ms="this.form.submit()">
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

            <a href="{{ route('invoice.create') }}" type="button" class="ml-auto px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tambah</a>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-sky-200 text-slate-800 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID Akun</th>
                        <th class="py-3 px-6 text-left">Nama Akun</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @forelse ($invoices as $invoice)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $invoice->idnumber }}</td>
                            <td class="py-3 px-6 text-left">{{ $invoice->nama }}</td>
                            <td class="py-3 px-6 text-left flex align-middle space-x-2">
                                <a href="{{ route('invoice.print', ['num' => $invoice->id]) }}" class="text-blue-500 hover:underline cursor-pointer flex justify-center align-middle" title="print" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus invoice ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline cursor-pointer flex justify-center align-middle" title="delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-3 px-6 text-center">Tidak ada data yang ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $invoices->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
