@empty($supplier)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger border-0 shadow-sm">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    <p class="mb-0">Data yang anda cari tidak ditemukan</p>
                </div>
                <a href="{{ url('/supplier') }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">
                    <i class="fas fa-info-circle mr-2"></i>Detail Supplier
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tr>
                            <th style="width: 200px">ID</th>
                            <td>{{ $supplier->supplier_id }}</td>
                        </tr>
                        <tr>
                            <th>Kode Supplier</th>
                            <td>{{ $supplier->supplier_kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama Supplier</th>
                            <td>{{ $supplier->supplier_nama }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $supplier->supplier_alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
            </div>
        </div>
    </div>
@endempty