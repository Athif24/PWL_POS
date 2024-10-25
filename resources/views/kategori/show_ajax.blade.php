@empty($kategori)
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
            <div class="modal-body text-center py-5">
                <div class="alert alert-danger d-inline-block">
                    <h5><i class="icon fas fa-ban mr-2"></i>Data tidak ditemukan!</h5>
                </div>
                <div class="mt-3">
                    <a href="{{ url('/kategori') }}" class="btn btn-warning">
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
                <h5 class="modal-title text-white" id="exampleModalLabel">
                    <i class="fas fa-info-circle mr-2"></i>Detail Kategori
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th class="bg-light text-right" width="30%">ID</th>
                        <td>{{ $kategori->kategori_id }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light text-right">Kode</th>
                        <td>{{ $kategori->kategori_kode }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light text-right">Nama</th>
                        <td>{{ $kategori->kategori_nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
            </div>
        </div>
    </div>
@endempty