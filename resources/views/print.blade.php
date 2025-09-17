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
                <td>{{ $invoice->id }}-{{ $invoice->account_id }}</td>
                <td></td>
                <td>{{ $invoice->account_id }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-5">
        <h2 class="text-lg font-bold">{{ $invoice->name }}</h2>
        <p class="mt-3 text-wrap w-130">{{ $invoice->address }}</p>
        <h2 class="text-lg font-bold text-end">
            <span class="mr-8">New Charge</span>
            {{ $invoice->total }}
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
            <tr>
                <td class="w-10 text-center">*</td>
                <td>IP TRANSIT - TERMIN I</td>
                <td class="w-50 text-end">{{ $invoice->amount }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-95 w-full flex">
        <div class="w-[60%] border-y-4 border-l-4 border-r-2 border-solid">
            <p>
                Payment can be done through direct transfer to one of the virtual account as follows: <br />
                - Account Name : {{ $invoice->name }} <br />
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
                <span>{{ $invoice->amount }}</span>
            </div>
            <div class="font-bold flex px-1 border-b-4 border-solid">
                <span class="w-80">TAX(VAT)</span>
                <span class="w-full text-center">:</span>
                <span>{{ $invoice->tax }}</span>
            </div>
            <div class="font-bold flex px-1 border-b-4 border-solid">
                <span class="w-80">Grand Total</span>
                <span class="w-full text-center">:</span>
                <span>{{ $invoice->total }}</span>
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
                <td>{{ $invoice->id }}-{{ $invoice->account_id }}</td>
                <td></td>
                <td>{{ $invoice->account_id }}</td>
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
            <tr>
                <td class="w-10 text-center">*</td>
                <td>IP TRANSIT - TERMIN I</td>
            </tr>
            <tr class="font-normal">
                <td class="w-10 text-center">1. </td>
                <td class="text-blue-600">IP TRANSIT INTERNATIONAL</td>
                <td></td>
                <td class="w-50 text-end text-blue-600">1000 MBPS</td>
                <td class="w-50 text-end text-blue-600">202504</td>
                <td class="w-50 text-end">{{ $invoice->amount }}</td>
            </tr>
            <tr>
                <td class="w-10 text-center"></td>
                <td>{{ $invoice->reason }}</td>
                <td class="text-blue-600">2076634434</td>
                <td class="w-50 text-end"></td>
                <td class="w-50 text-end"></td>
                <td class="w-50 text-end font-bold">{{ $invoice->amount }}</td>
            </tr>
            <tr></tr>
            <tr>
                <td colspan="5" class="text-end font-bold">Total:</td>
                <td class="font-bold text-end">{{ $invoice->amount }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-end font-bold">TAX(VAT):</td>
                <td class="font-bold text-end">{{ $invoice->tax }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-end font-bold">GRAND TOTAL :</td>
                <td class="font-bold text-end">{{ $invoice->total }}</td>
            </tr>
        </tbody>
    </table>

    <span class="text-[10px] mt-12">PT. Telkom Indonesia (Persero) Tbk -| Jl. Japati No. 1 Rt 000 Rw 000 Sadangserang Coblong Kota Bandung -| http://www.telkom.co.i</span>
</div>
@endsection