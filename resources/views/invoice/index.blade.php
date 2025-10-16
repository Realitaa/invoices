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
                        <th class="py-3 px-6 text-left">Periode</th>
                        <th class="py-3 px-6 text-left">Nama Akun</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @forelse ($invoices as $invoice)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $invoice->idnumber }}</td>
                            <td class="py-3 px-6 text-left">{{ sprintf("%02d", $invoice->bulan_tagihan) . $invoice->tahun_tagihan }}</td>
                            <td class="py-3 px-6 text-left">{{ $invoice->nama }}</td>
                            <td class="py-3 px-6 text-left flex align-middle space-x-2">
                                <a href="{{ route('invoice.show', ['invoice' => $invoice->id]) }}" class="text-sky-500 cursor-pointer flex justify-center items-center" title="Detail">
                                    <span class="icon-[material-symbols--info] size-7"></span>
                                </a>
                                <a href="{{ route('invoice.download', ['num' => $invoice->id]) }}" class="text-green-400 cursor-pointer flex justify-center items-center" title="Download">
                                    <span class="icon-[line-md--download] size-7"></span>
                                </a>
                                <a href="{{ route('invoice.preview', ['num' => $invoice->id]) }}" class="text-blue-500 cursor-pointer flex justify-center items-center" title="Preview" target="_blank">
                                    <span class="icon-[whh--preview] size-5"></span>
                                </a>
                                <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus invoice ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline cursor-pointer flex justify-center align-middle" title="delete">
                                        <span class="icon-[majesticons--trash] size-7"></span>
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
