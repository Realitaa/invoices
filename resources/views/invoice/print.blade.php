

@extends('layouts.paper')

@section('title', 'Print Invoice')

@section('page1')
<div class="mt-20">
    <table class="w-full table-fixed text-center">
        <thead>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                    Invoice Number
                </div>
            </th>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                Invoice Periode
                </div>
            </th>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                Account Number
                </div>
            </th>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                Payment Due Date
                </div>
            </th>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->nomor_tagihan }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->locale($invoice->bulan_tagihan)->translatedFormat('F') }}</td>
                <td>{{ $invoice->idnumber }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-5">
        <h2 class="text-lg font-bold">{{ $invoice->name }}</h2>
        <p class="mt-3 text-wrap w-130">{{ $invoice->address }}</p>
        <h2 class="text-lg font-bold text-end">
            <span class="mr-8">New Charge</span>
            {{ $invoice->grand }}
            <span class="ml-2">(IDR)</span>
        </h2>
        <p class="mt-3 text-end">
            <span class="mr-5">Status : </span>
            {{ $invoice->status }}
        </p>
    </div>

    <table class="mt-5 mx-auto font-bold w-11/12">
        <thead>
            <th class="bg-red-500">NO</th>
            <th class="text-start bg-red-500 border-l-2 border-white">DESCRIPTION</th>
            <th class="bg-red-500 border-l-2 border-white">AMOUNT</th>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="w-10 text-center">*</td>
                    <td>{{ $product->product_name }}</td>
                    <td class="w-50 text-end">{{ $product->total_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-95 w-full flex">
        <div class="w-[60%] border-y-4 border-l-4 border-r-2 border-solid">
            <p>
                Payment can be done through direct transfer to one of the virtual account as follows: <br />
                - Account Name : {{ $invoice->nama }} <br />
                - BANK MANDIRI <br />
                Nomor Virtual Account: 88111-8-00000014221
            </p>
            <div class="flex justify-end m-2">
            {!! QrCode::size(100)->generate($invoice->qrdata) !!}
            </div>
        </div>
        <div class="w-[40%] border-y-4 border-r-4 border-l-2 border-solid">
            <div class="font-bold flex px-1 border-b-4 border-solid">
                <span class="w-80">Sub Total</span>
                <span class="w-full text-center">:</span>
                <span class="w-70 text-right">{{ $invoice->subTotal }}</span>
            </div>
            <div class="font-bold flex px-1 border-b-4 border-solid">
                <span class="w-80">TAX(VAT)</span>
                <span class="w-full text-center">:</span>
                <span class="w-70 text-right">{{ $invoice->tax }}</span>
            </div>
            <div class="font-bold flex px-1 border-b-4 border-solid">
                <span class="w-80">Grand Total</span>
                <span class="w-full text-center">:</span>
                <span class="w-70 text-right">{{ $invoice->grand }}</span>
            </div>
            <div class="text-center flex flex-col">
                <span>Medan, {{ \Carbon\Carbon::today()->locale('id')->translatedFormat('d F Y') }}</span>
                <span class="font-bold mt-20 underline">MHD. ADNA MIRAZA</span>
                <span>SM SHARED SERVICE & GENERAL SUPPORT REG I</span>
            </div>
        </div>
    </div>
    <span class="text-[10px] mt-12">PT. Telkom Indonesia (Persero) Tbk -| Jl. Japati No. 1 Rt 000 Rw 000 Sadangserang Coblong Kota Bandung -| http://www.telkom.co.i</span>
</div>
@endsection

@section('page2')
<div class="mt-20">
    <table class="w-full table-fixed text-center">
        <thead>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                    Invoice Number
                </div>
            </th>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                Invoice Periode
                </div>
            </th>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                Account Number
                </div>
            </th>
            <th>
                <div class="bg-green-300 mx-auto rounded-b-xl w-40">
                Payment Due Date
                </div>
            </th>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->nomor_tagihan }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->locale($invoice->bulan_tagihan)->translatedFormat('F') }}</td>
                <td>{{ $invoice->idnumber }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-5">
        <h2 class="text-lg font-bold">{{ $invoice->name }}</h2>
        <p class="mt-3 text-wrap w-130">{{ $invoice->address }}</p>
    </div>

    <table class="mt-5 mx-auto font-bold w-11/12">
        <thead>
            <th class="bg-red-500">NO</th>
            <th class="bg-red-500 border-l-2 border-white">DESCRIPTION</th>
            <th class="bg-red-500 border-l-2 border-white">ID</th>
            <th class="bg-red-500 border-l-2 border-white">BW</th>
            <th class="bg-red-500 border-l-2 border-white">PERIODE</th>
            <th class="bg-red-500 border-l-2 border-white">AMOUNT</th>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="w-10 text-center">*</td>
                    <td>{{ $product->product_name }}</td>
                </tr>
                @foreach ($product->subproducts as $subproduct)
                    <tr class="font-normal">
                        <td class="w-10 text-center">{{ $subproduct->index }}</td>
                        <td>{{ $subproduct->subproduct_desc }}</td>
                        <td class="text-end">{{ $subproduct->subproduct_sid }}</td>
                        <td class="w-50 text-end">{{ $subproduct->subproduct_bw }}</td>
                        <td class="w-50 text-end">{{ $subproduct->subproduct_period }}</td>
                        <td class="w-50 text-end">{{ number_format($subproduct->subproduct_amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <td colspan="5" class="text-end font-bold">TOTAL:</td>
                <td class="font-bold text-end">{{ $invoice->subTotal }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-end font-bold">TAX(VAT):</td>
                <td class="font-bold text-end">{{ $invoice->tax }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-end font-bold">GRAND TOTAL :</td>
                <td class="font-bold text-end">{{ $invoice->grand }}</td>
            </tr>
        </tbody>
    </table>

    <span class="text-[10px] mt-12">PT. Telkom Indonesia (Persero) Tbk -| Jl. Japati No. 1 Rt 000 Rw 000 Sadangserang Coblong Kota Bandung -| http://www.telkom.co.i</span>
</div>
@endsection

@section('page3')
<div class="w-full border-4">
    <h1 class="underline font-bold text-3xl tracking-widest text-center">OFFICIAL RECEIPT</h1>
    <p class="text-center">NO : {{ $invoice->nomor_tagihan }}</p>

    <table class="mt-8 text-sm">
        <tr class="align-top">
            <td class="w-35 pl-3">
                Sudah terima dari <br />
                Received from
            </td>
            <td class="px-4">-</td>
            <td class="w-130">
                {{ $invoice->nama }} <br />
                {{ $invoice->alamat }} <br />
                <br />
                NPWP : {{ $invoice->npwp }}
            </td>
            <td class="flex justify-end me-4">
                {!! QrCode::size(100)->generate($invoice->qrdata) !!}
            </td>
        </tr>
        <tr class="align-top">
            <td class="w-35 pl-3">
                Uang sejumlah <br />
                The sum of
            </td>
            <td class="px-4">-</td>
            <td class="w-130" colspan="2">
                {{ $invoice->terbilang }} <br />
                {{ $invoice->spelled }} <br />
            </td>
        </tr>
        <tr class="align-top">
            <td class="w-35 pl-3">
                Untuk pembayaran <br />
                In payment of
            </td>
            <td class="px-4">-</td>
            <td class="w-130" colspan="2">Biaya jasa layanan Telkom Solution / Telkom Solution service cost.</td>
        </tr>
        <tr class="align-top">
            <td class="w-35 pl-3"></td>
            <td class="px-4"></td>
            <td class="" colspan="3">
                <div class="w-full flex justify-between pr-3">
                    <table>
                        <tr>
                            <td>Invoice Number</td>
                            <td class="px-2">:</td>
                            <td>{{ $invoice->nomor_tagihan }}</td>
                        </tr>
                        <tr>
                            <td>Billing Month</td>
                            <td class="px-2">:</td>
                            {{ \Carbon\Carbon::today()->locale('id')->translatedFormat('d F Y') }}
                            <td>{{ \Carbon\Carbon::create(month: $invoice->bulan_tagihan)->isoFormat('MMMM') . ' ' . $invoice->tahun_tagihan }}</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>Biaya / Cost</td>
                            <td class="px-2">:</td>
                            <td class="text-end">{{ $invoice->subTotal }}</td>
                        </tr>
                        <tr>
                            <td>PPN / VAT</td>
                            <td class="px-2">:</td>
                            <td class="text-end">{{ $invoice->tax }}</td>
                        </tr>
                        <tr>
                            <td>Material / Stamp Duty</td>
                            <td class="px-2">:</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr class="align-top">
            <td class="w-35 pl-3" colspan="2"></td>
            <td class="" colspan="4">
                <div class="w-full flex justify-between pr-3">
                    <span class="">Total</span>
                    <span class="text-end">{{ $invoice->grand }}</span>
                </div>
            </td>
        </tr>
    </table>
    <div class="flex justify-end m-3">
        <div class="flex flex-col text-center w-50">
            <span>Medan, {{ \Carbon\Carbon::today()->locale('id')->translatedFormat('d F Y') }}</span>
            <span class="font-bold mt-20 underline">MHD. ADNA MIRAZA</span>
            <span>SM SHARED SERVICE & GENERAL SUPPORT REG I</span>
        </div>
    </div>
</div>

<div class="mt-8 text-sm">
    <ul>
        <li>Surat Penetapan Sebagai Pemungut Bea Meterai Nomor : S-27/PBM/PJ/2021, Tanggal : 21 Desember 2021</li>
        <li>Kuitansi ini sah jika pembayaran telah diterima</li>
    </ul>
</div>

<div class="mt-6 text-sm">
    <ol>
        <li>Official Appointment Letter as Stamp Duty Collector Number : S-27/PBM/PJ/2021, Dated : December 21, 2021</li>
        <li> This billing receipt is valid only when the payment have already been received</li>
    </ol>
</div>
@endsection
