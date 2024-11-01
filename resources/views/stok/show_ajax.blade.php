@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger border-0 shadow-sm">
                    <h5 class="d-flex align-items-center">
                        <i class="icon fas fa-ban mr-2"></i>
                        Data yang anda cari tidak ditemukan
                    </h5>
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-info-circle mr-2"></i>Detail Stok
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <tbody>
                            <tr>
                                <th class="bg-light text-right align-middle" width="25%">ID</th>
                                <td class="font-weight-bold">{{ $stok->stok_id }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-right align-middle">Nama Supplier</th>
                                <td>{{ $stok->supplier->supplier_nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-right align-middle">Nama Barang</th>
                                <td>{{ $stok->barang->barang_nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-right align-middle">Penginput</th>
                                <td>{{ $stok->user->nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-right align-middle">Tanggal</th>
                                <td>{{ date('d/m/Y', strtotime($stok->stok_tanggal)) }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-right align-middle">Jumlah</th>
                                <td class="font-weight-bold">{{ $stok->stok_jumlah }}</td>
                            </tr>
                        </tbody>
                    </table>
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