@empty($transaksi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="alert alert-danger d-inline-block">
                    <h5 class="mb-0"><i class="icon fas fa-ban mr-2"></i> Data transaksi yang Anda cari tidak ditemukan</h5>
                </div>
                <div class="mt-3">
                    <a href="{{ url('/transaksi') }}" class="btn btn-warning">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-file-invoice mr-2"></i>Detail Transaksi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <!-- Informasi Utama Transaksi -->
                <div class="card mb-4">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Transaksi
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <tr>
                                <th class="text-right bg-light col-3 py-2">Kode Transaksi:</th>
                                <td class="col-9 py-2">{{ $transaksi->penjualan_kode }}</td>
                            </tr>
                            <tr>
                                <th class="text-right bg-light py-2">Tanggal:</th>
                                <td class="py-2">{{ date('d/m/Y', strtotime($transaksi->penjualan_tanggal)) }}</td>
                            </tr>
                            <tr>
                                <th class="text-right bg-light py-2">Pembeli:</th>
                                <td class="py-2">{{ $transaksi->pembeli }}</td>
                            </tr>
                            <tr>
                                <th class="text-right bg-light py-2">Petugas:</th>
                                <td class="py-2">{{ $transaksi->user->nama }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Detail Barang -->
                <div class="card">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-shopping-cart mr-2"></i>Detail Barang
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th>Nama Barang</th>
                                        <th class="text-right" width="20%">Harga</th>
                                        <th class="text-center" width="10%">Jumlah</th>
                                        <th class="text-right" width="20%">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi->penjualan_detail as $index => $detail)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $detail->barang->barang_nama }}</td>
                                        <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $detail->jumlah }}</td>
                                        <td class="text-right">Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light font-weight-bold">
                                    <tr>
                                        <th colspan="4" class="text-right">Total:</th>
                                        <th class="text-right">
                                            Rp {{ number_format($transaksi->penjualan_detail->sum(function($detail) {
                                                return $detail->harga * $detail->jumlah;
                                            }), 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-primary shadow-sm" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
            </div>
        </div>
    </div>
@endempty