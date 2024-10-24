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
            }
    
            td,
            th {
                padding: 4px 3px;
            }
    
            th {
                text-align: left;
            }
    
            .d-block {
                display: block;
            }
    
            img.image {
                width: auto;
                height: 80px;
                max-width: 150px;
                max-height: 150px;
            }
    
            .text-right {
                text-align: right;
            }
    
            .text-center {
                text-align: center;
            }
    
            .p-1 {
                padding: 5px 1px 5px 1px;
            }
    
            .font-10 {
                font-size: 10pt;
            }
    
            .font-11 {
                font-size: 11pt;
            }
    
            .font-12 {
                font-size: 12pt;
            }
    
            .font-13 {
                font-size: 13pt;
            }
    
            .border-bottom-header {
                border-bottom: 1px solid;
            }
    
            .border-all,
            .border-all th,
            .border-all td {
                border: 1px solid;
            }
        </style>
    </head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center"><img src="{{ asset('polinema-bw.png') }}" class="image"></td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN
                    PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI
                    MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang
                    65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-
                    105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <h3 class="text-center">LAPORAN DATA TRANSAKSI</h4>
        <table class="border-all" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Barang</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $t)
                    @foreach ($t->penjualan_detail as $detail)
                        <tr>
                            <td class="text-center">{{ $loop->parent->iteration }}</td>
                            <td>{{ $t->penjualan_kode }}</td>
                            <td>{{ date('d/m/Y', strtotime($t->penjualan_tanggal)) }}</td>
                            <td>{{ $t->pembeli }}</td>
                            <td>{{ $detail->barang->barang_nama }}</td>
                            <td class="text-right">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="text-right">{{ $detail->jumlah }}</td>
                            <td class="text-right">{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-right"><strong>Total Penjualan:</strong></td>
                    <td class="text-right"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </body>
    </html>
