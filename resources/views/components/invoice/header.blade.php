@props(['nt', 'btt', 'idn', 'pdd'])

<div>
    <table class="w-full table-fixed text-center">
        <thead>
            <th>
                <div class="thead-header">
                    Invoice Number
                </div>
            </th>
            <th>
                <div class="thead-header">
                Invoice Periode
                </div>
            </th>
            <th>
                <div class="thead-header">
                Account Number
                </div>
            </th>
            <th>
                <div class="thead-header">
                Payment Due Date
                </div>
            </th>
        </thead>
        <tbody>
            <tr>
                <td>{{ $nt }}</td>
                <td>{{ $btt }}</td>
                <td>{{ $idn }}</td>
                <td>{{ \Carbon\Carbon::parse($pdd)->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
</div>