@extends('layouts.app')

@section('title', 'Insert Invoice')

@section('scripts')
<script>
    function serviceTable() {
        return {
            services: [],
            addService() {
                this.services.push({
                    id: Date.now() + Math.random(),
                    name: '',
                    items: []
                });
            },
            removeService(idx) {
                this.services.splice(idx, 1);
            },
            addServiceItem(serviceIdx) {
                this.services[serviceIdx].items.push({
                    id: Date.now() + Math.random(),
                });
            },
            removeServiceItem(serviceIdx, itemIdx) {
                this.services[serviceIdx].items.splice(itemIdx, 1);
            }
        }
    }

    function dropdownSearch() {
        return {
            query: '',
            results: [],
            selectedValue: '',
            search() {
                if (this.query.length > 0) {
                    fetch(`/api/customer/search?query=${this.query}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data;
                        });
                } else {
                    this.results = [];
                }
            },
            select(result) {
                this.query = result.idnumber + ' - ' +result.bpname;
                this.selectedValueId = result.idnumber;
                this.selectedValueName = result.bpname;
                this.selectedValueNPWP = result.npwp_trems;
                this.results = [];
            }
        };
    }
</script>
@endsection

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">Membuat Invoice Baru</h2>
            <p class="mt-1 text-sm text-gray-600">Isi detail berikut untuk membuat invoice baru.</p>
        </div>

        <!-- Form Body -->
        <form action="{{ route('invoice.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <h2 class="text-xl font-bold text-gray-900">Detail Invoice</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div x-data="dropdownSearch()" class="relative">
                    <label for="searchable_dropdown" class="block text-sm font-medium text-gray-700 mb-2">
                        Pemilik Invoice <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        id="searchable_dropdown"
                        x-model="query"
                        @input.debounce.500ms="search"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Search...">
                    <div x-show="results.length > 0" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                        <ul>
                            <template x-for="result in results" :key="result.rn">
                                <li @click="select(result)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                    <span x-text="result.idnumber"></span> - <span x-text="result.bpname"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <input type="hidden" name="idnumber" :value="selectedValueId">
                    <input type="hidden" name="nama" :value="selectedValueName">
                    <input type="hidden" name="npwp" :value="selectedValueNPWP">
                    @error('id')
                        <p class="mt-1 text-sm text-red-600">Anda belum memilih customer</p>
                    @enderror
                </div>

                <div>
                    <label for="nomor_tagihan" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Tagihan <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="nomor_tagihan"
                           name="nomor_tagihan"
                           value="{{ old('nomor_tagihan') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('due_date') border-red-500 @enderror"
                           required>
                    @error('nomor_tagihan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 1: Reason and Due Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Invoices Manual <span class="text-red-500">*</span>
                    </label>
                    <select id="tipe_invoice_manual"
                            name="tipe_invoice_manual"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('payment') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Alasan</option>
                        <option value="PROSES AOSODOMORO" {{ old('tipe_invoice_manual') == 'PROSES AOSODOMORO' ? 'selected' : '' }}>PROSES AOSODOMORO</option>
                        <option value="RENEWAL KONTRAK" {{ old('tipe_invoice_manual') == 'RENEWAL KONTRAK' ? 'selected' : '' }}>RENEWAL KONTRAK</option>
                        <option value="ADJUSTMENT" {{ old('tipe_invoice_manual') == 'ADJUSTMENT' ? 'selected' : '' }}>ADJUSTMENT</option>
                        <option value="BUNDLING" {{ old('tipe_invoice_manual') == 'BUNDLING' ? 'selected' : '' }}>BUNDLING</option>
                        <option value="BY REKON/USAGE" {{ old('tipe_invoice_manual') == 'BY REKON/USAGE' ? 'selected' : '' }}>BY REKON/USAGE</option>
                    </select>
                    @error('tipe_invoice_manual')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_akhir_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Akhir Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="tanggal_akhir_pembayaran"
                           name="tanggal_akhir_pembayaran"
                           value="{{ old('tanggal_akhir_pembayaran') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('tanggal_akhir_pembayaran') border-red-500 @enderror"
                           required>
                    @error('tanggal_akhir_pembayaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 2: NPWP and Amount -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bulan_tagihan" class="block text-sm font-medium text-gray-700 mb-2">
                        Bulan Tagihan <span class="text-red-500">*</span>
                    </label>
                    <select id="bulan_tagihan"
                            name="bulan_tagihan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('payment') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Bulan</option>
                        @for ($i = 1; $i <=12; $i++)
                            <option value="{{ $i }}" {{ old('bulan_tagihan') == $i ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $i)->format('m') }}</option>
                        @endfor
                    </select>
                    @error('bulan_tagihan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tahun_tagihan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Tagihan <span class="text-red-500">*</span>
                    </label>
                    <input type="year"
                           id="tahun_tagihan"
                           name="tahun_tagihan"
                           value="{{ old('tahun_tagihan') ? old('tahun_tagihan') : date('Y') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('due_date') border-red-500 @enderror"
                           required>
                    @error('tahun_tagihan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 3: Address (Full Width) -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat
                </label>
                <textarea id="alamat"
                          name="alamat"
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('note') border-red-500 @enderror"
                          placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                @error('note')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="text-xl font-bold text-gray-900">Keterangan Invoice Manual</h2>

            <div>
                <label for="keterangan_invoice_manual" class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan Invoice Manual
                </label>
                <textarea id="keterangan_invoice_manual"
                          name="keterangan_invoice_manual"
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('keterangan_invoice_manual') border-red-500 @enderror"
                          placeholder="Masukkan alasan terhadap invoice manual">{{ old('keterangan_invoice_manual') }}</textarea>
                @error('keterangan_invoice_manual')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nomor_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Order <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="nomor_order"
                           name="nomor_order"
                           value="{{ old('nomor_order') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('due_date') border-red-500 @enderror"
                           required>
                    @error('nomor_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_komitmen_penyelesaian" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Komitmen Penyelesaian <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="tanggal_komitmen_penyelesaian"
                           name="tanggal_komitmen_penyelesaian"
                           value="{{ old('tanggal_komitmen_penyelesaian') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('tanggal_komitmen_penyelesaian') border-red-500 @enderror"
                           required>
                    @error('tanggal_komitmen_penyelesaian')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                    <label for="status_order_terakhir" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Order Terakhir <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="status_order_terakhir"
                           name="status_order_terakhir"
                           value="{{ old('status_order_terakhir') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('due_date') border-red-500 @enderror"
                           required>
                    @error('status_order_terakhir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            <h2 class="text-xl font-bold text-gray-900">Detail Service</h2>

            <div x-data="serviceTable()" class="mt-6">
    <!-- Tombol tambah service -->
    <button type="button"
        @click="addService"
        class="mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        + Tambah Service
    </button>

    <!-- Tabel Service dan Service Item -->
    <template x-for="(service, sIdx) in services" :key="service.id">
        <div class="mb-6 border rounded p-4 bg-gray-50">
            <div class="flex items-center mb-2">
                <input type="text" x-model="service.name" placeholder="Nama Service"
                    class="mr-2 px-2 py-1 border rounded w-3/4" />
                <button type="button" @click="removeService(sIdx)"
                    class="ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus Service</button>
            </div>
            <!-- Tombol tambah service item -->
            <button type="button"
                @click="addServiceItem(sIdx)"
                class="mb-2 px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Tambah Service Item
            </button>
            <!-- Tabel Service Item -->
            <table class="w-full border mt-2">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">DESCRIPTION</th>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">BW</th>
                        <th class="p-2 border">PERIODE</th>
                        <th class="p-2 border">AMOUNT</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, iIdx) in service.items" :key="item.id">
                        <tr>
                            <td class="p-2 border">
                                <textarea type="text" x-model="item.description" placeholder="Deskripsi Item"
                                    class="px-2 py-1 border rounded w-full"></textarea>
                            </td>
                            <td class="p-2 border">
                                <input type="text" x-model="item.service_item_id" class="px-2 py-1 border rounded" />
                            </td>
                            <td class="p-2 border">
                                <input type="text" x-model="item.bandwith" class="px-2 py-1 border rounded w-30" />
                            </td>
                            <td class="p-2 border">
                                <input type="text" x-model="item.periode" class="px-2 py-1 border rounded w-20" />
                            </td>
                            <td class="p-2 border">
                                <input type="text" x-model="item.amount" class="px-2 py-1 border rounded" />
                            </td>
                            <td class="p-2 border">
                                <button type="button" @click="removeServiceItem(sIdx, iIdx)"
                                    class="px-2 py-1 bg-red-400 text-white rounded hover:bg-red-600">Hapus</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </template>

    <!-- Debug JSON -->
    <div class="mt-4">
        <h3 class="font-bold">Debug JSON:</h3>
        <pre class="bg-gray-100 p-2 rounded text-xs" x-text="JSON.stringify(services, null, 2)"></pre>
    </div>
</div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('invoice.index') }}"
                   class="px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
