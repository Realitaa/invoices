

@extends('layouts.app')

@section('title', 'Tabel customer')

@section('content')
<div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar customer</h1>

        <!-- Form Filter -->
        <!-- <form method="GET" action="{{ route('customer.index') }}" class="mb-4 flex space-x-4">
            <div>
                <label for="search" class="mr-2">Cari:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="border rounded px-2 py-1" placeholder="Nama akun" x-model.debounce.500ms="this.form.submit()">
            </div>

            <div>
                <label for="perPage" class="mr-2">Item per halaman:</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="5" {{ request('perPage', 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('perPage', 10) == 20 ? 'selected' : '' }}>20</option>
                </select>
            </div> -->

            <!-- Tombol Submit -->
            <!-- <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Filter</button>
        </form> -->

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-sky-200 text-slate-800 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID Akun</th>
                        <th class="py-3 px-6 text-left">Nama Akun</th>
                        <th class="py-3 px-6 text-left">NPWP</th>
                        <th class="py-3 px-6 text-left">Ubis</th>
                        <th class="py-3 px-6 text-left">Bisnis Area</th>
                        <th class="py-3 px-6 text-left">Bisnis Share</th>
                        <th class="py-3 px-6 text-left">Divisi</th>
                        <th class="py-3 px-6 text-left">Witel</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @foreach ($customers as $customer)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $customer->idnumber }}</td>
                            <td class="py-3 px-6 text-left">{{ $customer->bpname }}</td>
                            <td class="py-3 px-6 text-left">{{ $customer->npwp_trems }}</td>
                            <td class="py-3 px-6 text-left">{{ $customer->ubis }}</td>
                            <td class="py-3 px-6 text-left">{{ $customer->bisnis_area }}</td>
                            <td class="py-3 px-6 text-left">{{ $customer->business_share }}</td>
                            <td class="py-3 px-6 text-left">{{ $customer->divisi }}</td>
                            <td class="py-3 px-6 text-left">{{ $customer->witel }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $customers->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
