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
                table-layout: fixed;
            }
    
            td, th {
                padding: 4px 3px;
                text-align: center;
                border: 1px solid black;
                vertical-align: middle;
            }
    
            thead {
                display: table-header-group;
            }
            
            tbody {
                display: table-row-group;
            }
            
            tr {
                page-break-inside: avoid;
            }
            
            tfoot {
                display: table-footer-group;
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
    
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .text-left { text-align: left; }
    
            .font-10 { font-size: 10pt; }
            .font-11 { font-size: 11pt; }
            .font-12 { font-size: 12pt; }
            .font-13 { font-size: 13pt; }
    
            .border-bottom-header {
                border-bottom: 1px solid;
                margin-bottom: 20px;
            }

            /* Pengaturan lebar kolom */
            .col-no { width: 5%; }
            .col-date { width: 12%; }
            .col-code { width: 10%; }
            .col-buyer { width: 12%; }
            .col-id { width: 8%; }
            .col-item { width: 20%; }
            .col-qty { width: 8%; }
            .col-price { width: 12%; }
            .col-total { width: 13%; }

            /* Style untuk group transaksi */
            .transaction-group {
                border-top: 2px solid black;
            }

            .transaction-detail td {
                border-top: 1px solid #ddd;
            }

            /* Mengatur ulang border untuk sel yang digabung */
            .no-top-border { 
                border-top: none !important; 
            }
            .no-bottom-border { 
                border-bottom: none !important; 
            }

            @page {
                margin: 20mm;
                size: A4;
            }

            /* Memastikan konten tidak terpotong */
            .page-break-inside-avoid {
                page-break-inside: avoid !important;
            }
        </style>
    </head>
    <body>
        <table class="border-bottom-header">
            <tr>
                <td width="15%" class="text-center" style="border: none;">
                    <img src="{{ asset('polinema-bw.png') }}" class="image">
                </td>
                <td width="85%" style="border: none;">
                    <span class="text-center d-block font-11">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                    <span class="text-center d-block font-13">POLITEKNIK NEGERI MALANG</span>
                    <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                    <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                    <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
                </td>
            </tr>
        </table>

        <h3 class="text-center">LAPORAN DATA TRANSAKSI</h3>

        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-date">Tanggal</th>
                    <th class="col-code">Kode Transaksi</th>
                    <th class="col-buyer">Pembeli</th>
                    <th class="col-item">Barang</th>
                    <th class="col-qty">Jumlah</th>
                    <th class="col-price">Harga</th>
                    <th class="col-total">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $currentNo = 1;
                    $currentTransactionId = null;
                @endphp

                @foreach ($transaksi as $t)
                    @php
                        $isNewTransaction = $currentTransactionId !== $t->penjualan_kode;
                        $detailCount = count($t->penjualan_detail);
                    @endphp

                    @foreach ($t->penjualan_detail as $index => $detail)
                        <tr class="page-break-inside-avoid {{ $isNewTransaction && $index === 0 ? 'transaction-group' : 'transaction-detail' }}">
                            @if ($index === 0)
                                <td rowspan="{{ $detailCount }}" class="text-center">{{ $currentNo }}</td>
                                <td rowspan="{{ $detailCount }}" class="text-center">{{ date('Y-m-d H:i:s', strtotime($t->penjualan_tanggal)) }}</td>
                                <td rowspan="{{ $detailCount }}" class="text-center">{{ $t->penjualan_kode }}</td>
                                <td rowspan="{{ $detailCount }}" class="text-center">{{ $t->pembeli }}</td>
                            @endif
                            <td class="text-left">{{ $detail->barang->barang_nama }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-right">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach

                    @php
                        if ($isNewTransaction) {
                            $currentNo++;
                            $currentTransactionId = $t->penjualan_kode;
                        }
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="text-right"><strong>Total Penjualan:</strong></td>
                    <td class="text-right"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>