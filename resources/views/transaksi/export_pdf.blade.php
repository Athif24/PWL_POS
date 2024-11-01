<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
            margin-bottom: 20px;
            width: 85%;
            margin-left: auto;
            margin-right: auto;
        }

        .border-bottom-header span {
            text-align: center;
            display: block;
            margin: 0 auto;
        }

        .image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
            display: block;
            margin: 0 auto;
        }

        h3.text-center {
            text-align: center;
            width: 85%;
            margin: 20px auto;
            font-size: 12pt;
        }

        td, th {
            padding: 4px 3px;
            font-size: 10pt;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid black;
        }

        .total-row td {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center"><img src="{{ asset('polinema-bw.png') }}" class="image"></td>
            <td width="85%">
                <span class="text-center d-block font-11">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, (0341-404420), Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN DATA TRANSAKSI</h3>

    <table class="border-all">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Pembeli</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentTransactionId = null;
                $rowCount = [];
                
                // First pass: count rows for each transaction
                foreach ($transaksi as $t) {
                    $rowCount[$t->penjualan_kode] = count($t->penjualan_detail);
                }
            @endphp
            
            @foreach ($transaksi as $t)
                @foreach ($t->penjualan_detail as $index => $detail)
                    <tr>
                        @if ($index === 0)
                            <td class="text-center" rowspan="{{ $rowCount[$t->penjualan_kode] }}">{{ $loop->parent->iteration }}</td>
                            <td rowspan="{{ $rowCount[$t->penjualan_kode] }}">{{ date('Y-m-d', strtotime($t->penjualan_tanggal)) }}</td>
                            <td rowspan="{{ $rowCount[$t->penjualan_kode] }}">{{ $t->penjualan_kode }}</td>
                            <td rowspan="{{ $rowCount[$t->penjualan_kode] }}">{{ $t->pembeli }}</td>
                        @endif
                        <td>{{ $detail->barang->barang_nama }}</td>
                        <td class="text-center">{{ $detail->jumlah }}</td>
                        <td class="text-right">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr class="total-row">
                <td colspan="7" class="text-right">Total Penjualan:</td>
                <td class="text-right">{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>