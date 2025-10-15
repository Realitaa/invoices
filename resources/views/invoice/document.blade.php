@extends('layouts.paper')

@section('title', 'Print Invoice')

@section('page1')
<div class="mt-20 mx-8">
    <x-invoice.header
        :nt="$invoice->nomor_tagihan"
        :btt="$invoice->bulan_tahun_tagihan"
        :idn="$invoice->idnumber"
        :pdd="$invoice->tanggal_akhir_pembayaran"
    />

    <div class="mt-5">
        <h2 class="text-lg font-bold">{{ $invoice->nama }}</h2>
        <p class="mt-3 text-wrap">{!! nl2br(e($invoice->alamat)) !!}</p>
        <h2 class="text-lg font-bold text-end">
            <span class="mr-8">New Charge</span>
            {{ $invoice->grand }}
            <span class="ml-1">(IDR)</span>
        </h2>
        <p class="mt-3 text-end">
            <span class="mr-5">Status : </span>
            {{ $invoice->status }}
        </p>
    </div>

    <table class="mt-5 mx-auto w-full font-normal text-[12px]">
        <thead>
            <th class="th-no">NO</th>
            <th class="th-data">DESCRIPTION</th>
            <th class="th-data">AMOUNT</th>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="w-10 text-center py-2 align-top">{{ $loop->iteration }}.</td>
                    <td class="py-2">{{ $product->product_name }}</td>
                    <td class="w-30 text-end py-2">{{ $product->total_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="absolute bottom-10 w-full">
        <div class="flex">
            <div class="w-[58%] border-y-4 border-l-4 border-r-2 border-solid px-2 py-1 italic">
                <p>
                    Payment can be done through direct transfer to one of the virtual account as follows: <br />
                    - Account Name : <span class="font-bold">{{ $invoice->nama }}</span> <br />
                    - BANK MANDIRI <br />
                    Nomor Virtual Account: <span class="font-bold">88111-8-{{ sprintf("%010d", $invoice->idnumber) }}</span>
                </p>
                <div class="flex justify-end">
                {!! QrCode::size(100)->generate($invoice->qrdata) !!}
                </div>
            </div>
            <div class="w-[35%] border-y-4 border-r-4 border-l-2 border-solid">
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
                    <span>Medan, {{ \Carbon\Carbon::parse($invoice->tanggal_tanda_tangan)->locale('id')->translatedFormat('d F Y') }}</span>
                    <span class="font-bold mt-20 underline">MHD. ADNA MIRAZA</span>
                    <span>SM SHARED SERVICE & <br /> GENERAL SUPPORT REG I</span>
                </div>
            </div>
        </div>
    </div>
    <x-invoice.footer />
</div>
@endsection

@section('page2')
<div class="mt-20 mx-8">
    <x-invoice.header
        :nt="$invoice->nomor_tagihan"
        :btt="$invoice->bulan_tahun_tagihan"
        :idn="$invoice->idnumber"
        :pdd="$invoice->tanggal_akhir_pembayaran"
    />

    <div class="mt-5">
        <h2 class="text-lg font-bold">{{ $invoice->nama }}</h2>
        <p class="mt-3 text-wrap w-130">{!! nl2br(e($invoice->alamat)) !!}</p>
    </div>

    <table class="mt-5 mx-auto font-bold text-[12px] w-full">
        <thead>
            <th class="th-no">NO</th>
            <th class="th-data">DESCRIPTION</th>
            <th class="th-data">ID</th>
            <th class="th-data">BW</th>
            <th class="th-data">PERIODE</th>
            <th class="th-data">AMOUNT</th>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="w-10 text-center">&#8226;</td>
                    <td>{{ $product->product_name }}</td>
                </tr>
                @foreach ($product->subproducts as $subproduct)
                    <tr class="font-normal">
                        <td class="w-10 text-center align-top">{{ $loop->iteration }}</td>
                        <td class="w-300">{!! nl2br(e($subproduct->subproduct_desc)) !!}</td>
                        <td class="w-30 text-end">{{ $subproduct->subproduct_sid }}</td>
                        <td class="w-30 text-end">{{ $subproduct->subproduct_bw }}</td>
                        <td class="w-30 text-end">{{ $subproduct->subproduct_period }}</td>
                        <td class="w-30 text-end">{{ number_format($subproduct->subproduct_amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="font-bold text-end" colspan="5">Sub total {{ $product->product_name }}:</td>
                    <td class="font-bold text-end">{{ $product->total_amount }}
                </tr>
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
</div>
@endsection

@section('page3')
<div class="w-[92%] border-4 mx-8 mt-20">
    <div class="my-7">
        <h1 class="underline font-bold text-3xl tracking-[0.5rem] [word-spacing:30px] text-center ">OFFICIAL RECEIPT</h1>
        <p class="text-center">NO : {{ $invoice->nomor_tagihan }}</p>
    </div>

    <table class="text-sm">
        <tr class="align-top h-25 border-b-6 border-white">
            <td class="w-35 pl-3 italic">
                Sudah terima dari <br />
                Received from
            </td>
            <td class="px-4">-</td>
            <td class="w-130">
                <div class="bg-[#E3E3DC] p-2 flex justify-between">
                    <div>
                        <b>{{ $invoice->nama }}</b>
                        <div class="my-4">
                            {!! nl2br(e($invoice->alamat)) !!}
                        </div>
                        NPWP : {{ $invoice->npwp }}
                    </div>
                    <div class="bg-white p-1">
                        {!! QrCode::size(100)->generate($invoice->qrdata) !!}
                    </div>
                </div>
            </td>
        </tr>
        <tr class="align-top border-b-6 border-white">
            <td class="w-35 pl-3 italic ">
                Uang sejumlah <br />
                The sum of
            </td>
            <td class="px-4">-</td>
            <td class="w-130" colspan="2">
                <div class="bg-[#E3E3DC] p-2 mb-2">
                    {{ $invoice->terbilang }}
                </div>
                <div class="bg-[#E3E3DC] p-2">
                    {{ $invoice->spelled }} <br />
                </div>
            </td>
        </tr>
        <tr class="align-top border-b-6 border-white">
            <td class="w-40 pl-3 italic ">
                Untuk pembayaran <br />
                In payment of
            </td>
            <td class="px-4">-</td>
            <td class="w-130 bg-[#E3E3DC] p-2" colspan="2">Biaya jasa layanan Telkom Solution / Telkom Solution service cost.</td>
        </tr>
        <tr class="align-top border-b-6 border-white">
            <td class="w-35 pl-3"></td>
            <td class="px-4"></td>
            <td class="" colspan="3">
                <div class="w-full flex space-x-2">
                    <div class="bg-[#E3E3DC] w-1/2 pb-4 px-2">
                        <table class="w-full">
                            <tr>
                                <td>- Invoice Number</td>
                                <td class="px-2">:</td>
                                <td>{{ $invoice->nomor_tagihan }}</td>
                            </tr>
                            <tr>
                                <td>- Billing Month</td>
                                <td class="px-2">:</td>
                                <td>{{ \Carbon\Carbon::create(month: $invoice->bulan_tagihan)->isoFormat('MMMM') . ' ' . $invoice->tahun_tagihan }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="bg-[#E3E3DC] w-1/2 pb-4 px-2">
                        <table class="w-full">
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
                </div>
            </td>
        </tr>
        <tr class="align-top border-b-6 border-white">
            <td class="w-35 pl-3" colspan="2"></td>
            <td class="" colspan="4">
                <div class="w-full flex justify-between p-2 bg-[#E3E3DC]">
                    <span>Grand Total (IDR)</span>
                    <span class="text-end">{{ $invoice->grand }}</span>
                </div>
            </td>
        </tr>
    </table>
    <div class="flex justify-end mt-20 mx-3">
        <div class="flex flex-col text-center w-50">
            <span>Medan, {{ \Carbon\Carbon::parse($invoice->tanggal_tanda_tangan)->locale('id')->translatedFormat('d F Y') }}</span>
            <span class="font-bold mt-20 underline">MHD. ADNA MIRAZA</span>
            <span>SM SHARED SERVICE & GENERAL SUPPORT REG I</span>
        </div>
    </div>
</div>

<div class="mt-8 mx-8 text-sm">
    <b>Catatan :</b>
    <ul>
        <li>Surat Penetapan Sebagai Pemungut Bea Meterai Nomor : S-27/PBM/PJ/2021, Tanggal : 21 Desember 2021</li>
        <li>Kuitansi ini sah jika pembayaran telah diterima</li>
    </ul>
</div>

<div class="mt-6 mx-8 text-sm">
    <b>Note :</b>
    <ol>
        <li>Official Appointment Letter as Stamp Duty Collector Number : S-27/PBM/PJ/2021, Dated : December 21, 2021</li>
        <li> This billing receipt is valid only when the payment have already been received</li>
    </ol>
</div>
@endsection
