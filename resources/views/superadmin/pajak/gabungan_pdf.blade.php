<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pajak Gabungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 5px;
        }
        .header p {
            margin: 5px 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #3d8b99;
            color: white;
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .page-number {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PAJAK GABUNGAN</h2>
        @if($bulan_tahun)
            <p>Bulan - Tahun: {{ $bulan_tahun->bulan }} {{ $bulan_tahun->tahun }}</p>
        @endif
        @if($skpd)
            <p>SKPD: {{ $skpd->nama }}</p>
        @endif
    </div>

    <table>
        <thead style="background-color: #3d8b99;">
            <tr class="text-white">
                <th style="border: 1px solid rgb(19, 19, 19)">No</th>
                <th style="border: 1px solid rgb(19, 19, 19)">NIP</th>
                <th style="border: 1px solid rgb(19, 19, 19)">Nama</th>
                <th style="border: 1px solid rgb(19, 19, 19)" class="text-right">Pajak TPP</th>
                <th style="border: 1px solid rgb(19, 19, 19)" class="text-right">Pajak THR</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td style="border: 1px solid rgb(19, 19, 19)" class="text-center">{{ $index + 1 }}</td>
                    <td style="border: 1px solid rgb(19, 19, 19)">{{ $item['nip'] }}</td>
                    <td style="border: 1px solid rgb(19, 19, 19)">{{ $item['nama'] }}</td>
                    <td style="border: 1px solid rgb(19, 19, 19)" class="text-right">{{ number_format($item['pph_terutang'] ?? 0, 0, ',', '.') }}</td>
                    <td style="border: 1px solid rgb(19, 19, 19)" class="text-right">{{ number_format($item['pph_thr'] ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot style="background-color:#e9ecef;font-weight:bold;">
            <tr>
                <td colspan="3" style="border: 1px solid rgb(19, 19, 19)">Total Pajak</td>
                <td style="border: 1px solid rgb(19, 19, 19)" class="text-right">{{ number_format($total_pajak, 0, ',', '.') }}</td>
                <td style="border: 1px solid rgb(19, 19, 19)" class="text-right">{{ number_format($total_thr, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>
