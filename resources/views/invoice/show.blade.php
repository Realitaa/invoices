@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Invoice #{{ $invoice->nomor_tagihan }}</h2>
                <p class="mt-1 text-sm text-gray-600">Dibuat pada: {{ $invoice->created_at->format('d F Y') }}</p>
            </div>
            <a href="{{ route('invoice.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Kembali
            </a>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">
            <!-- Informasi Customer dan Invoice -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Ditagihkan Kepada:</h3>
                    <div class="text-gray-600">
                        <p class="font-bold">{{ $invoice->nama }}</p>
                        <p>ID Pelanggan: {{ $invoice->idnumber }}</p>
                        <p>NPWP: {{ $invoice->npwp ?? '-' }}</p>
                        <p class="mt-2">{!! nl2br(e($invoice->alamat)) !!}</p>
                    </div>
                </div>
                <!-- Invoice Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Detail Tagihan:</h3>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-gray-600">
                        <span class="font-semibold">Nomor Tagihan:</span>
                        <span>{{ $invoice->nomor_tagihan }}</span>

                        <span class="font-semibold">Bulan Tagihan:</span>
                        <span>{{ \Carbon\Carbon::create(month: $invoice->bulan_tagihan, year: $invoice->tahun_tagihan)->isoFormat('MMMM YYYY') }}</span>

                        <span class="font-semibold">Tgl. Akhir Pembayaran:</span>
                        <span>{{ \Carbon\Carbon::parse($invoice->tanggal_akhir_pembayaran)->format('d F Y') }}</span>

                        <span class="font-semibold">Tgl. Tanda Tangan:</span>
                        <span>{{ \Carbon\Carbon::parse($invoice->tanggal_tanda_tangan)->format('d F Y') }}</span>

                        <span class="font-semibold">Status Pembayaran:</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $invoice->payment ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $invoice->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Keterangan Invoice Manual -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Keterangan Invoice Manual</h3>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-gray-600">
                    <span class="font-semibold">Tipe:</span>
                    <span>{{ $invoice->tipe_invoice_manual }}</span>

                    <span class="font-semibold">Nomor Order:</span>
                    <span>{{ $invoice->nomor_order }}</span>

                    <span class="font-semibold">Status Order Terakhir:</span>
                    <span>{{ $invoice->status_order_terakhir }}</span>

                    <span class="font-semibold">Keterangan:</span>
                    <p>{{ $invoice->keterangan_invoice_manual ?? '-' }}</p>
                </div>
            </div>

            <!-- Detail Produk -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Rincian Produk</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">No</th>
                                <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">Deskripsi</th>
                                <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">ID</th>
                                <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">BW</th>
                                <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-600">Periode</th>
                                <th class="py-2 px-4 border-b text-right text-sm font-medium text-gray-600">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($invoice->products as $product)
                                <tr class="font-bold bg-gray-50">
                                    <td class="py-2 px-4 border-b" colspan="5">{{ $product->product_name }}</td>
                                    <td class="py-2 px-4 border-b text-right">{{ $product->total_amount }}</td>
                                </tr>
                                @foreach ($product->subproducts as $subproduct)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                                        <td class="py-2 px-4 border-b">{!! nl2br(e($subproduct->subproduct_desc)) !!}</td>
                                        <td class="py-2 px-4 border-b">{{ $subproduct->subproduct_sid }}</td>
                                        <td class="py-2 px-4 border-b">{{ $subproduct->subproduct_bw }}</td>
                                        <td class="py-2 px-4 border-b">{{ $subproduct->subproduct_period }}</td>
                                        <td class="py-2 px-4 border-b text-right">{{ number_format($subproduct->subproduct_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total -->
            <div class="flex justify-end">
                <div class="w-full md:w-1/3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="font-semibold text-gray-600">Subtotal</span>
                        <span class="text-gray-800">Rp {{ $invoice->subTotal }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="font-semibold text-gray-600">Pajak (11%)</span>
                        <span class="text-gray-800">Rp {{ $invoice->tax }}</span>
                    </div>
                    <div class="flex justify-between py-2 font-bold text-lg">
                        <span class="text-gray-900">Grand Total</span>
                        <span class="text-gray-900">Rp {{ $invoice->grand }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('invoices.stamp', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center justify-center w-full">
                    <label for="stamped_invoice" id="dropzone-label" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div id="dropzone-content" class="flex flex-col items-center justify-center pt-3 pb-3">
                            <span class="icon-[clarity--upload-cloud-line] size-11"></span>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop <span class="font-bold">file invoice yang sudah di stamp.</span></p>
                            <p class="text-xs text-gray-500">File PDF</p>
                        </div>
                        <input id="stamped_invoice" name="stamped_invoice" type="file" class="hidden" accept=".pdf" />
                    </label>
                </div>
                @error('stamped_invoice')
                    <x-toast message="File harus PDF maksimal 2MB!" />
                @enderror
                <div class="flex justify-end">
                    <button type="submit" id="btn-submit" class="mt-4 bg-orange-400 hover:bg-orange-500 text-white px-4 py-2 rounded cursor-pointer hidden">Upload Invoice yang telah di stamp</button>
                </div>
            </form>

            <!-- Aksi -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('invoice.preview', ['num' => $invoice->id]) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Preview PDF
                </a>
                <a href="{{ route('invoice.download', ['num' => $invoice->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const dropzoneLabel = document.getElementById('dropzone-label');
    const fileInput = document.getElementById('stamped_invoice');
    const dropzoneContent = document.getElementById('dropzone-content');
    const btnSubmit = document.getElementById('btn-submit');

    function updateDropzoneContent(file) {
        if (file) {
            dropzoneContent.innerHTML = `
                <span class="icon-[mdi--file-check] size-11 text-green-500"></span>
                <p class="mt-2 text-sm text-gray-700 font-semibold">${file.name}</p>
                <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
            `;
        }
    }

    dropzoneLabel.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzoneLabel.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropzoneLabel.addEventListener('dragleave', () => {
        dropzoneLabel.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropzoneLabel.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzoneLabel.classList.remove('border-blue-500', 'bg-blue-50');

        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateDropzoneContent(fileInput.files[0]);
            btnSubmit.classList.remove('hidden');
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) {
            updateDropzoneContent(fileInput.files[0]);
            btnSubmit.classList.remove('hidden');
        }
    });
</script>
@endsection
