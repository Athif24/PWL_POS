@empty($level)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0 shadow">
        <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="exampleModalLabel">
                <i class="fas fa-exclamation-triangle me-2"></i>Kesalahan
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body py-4">
            <div class="alert alert-danger border-0 shadow-sm">
                <h5 class="mb-2"><i class="icon fas fa-ban me-2"></i>Kesalahan!</h5>
                <p class="mb-0">Data yang anda cari tidak ditemukan</p>
            </div>
            <a href="{{ url('/level') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0 shadow">
        <div class="modal-header bg-info text-white">
            <h5 class="modal-title" id="exampleModalLabel">
                <i class="fas fa-info-circle me-2"></i>Detail Level
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-hover mb-0">
                <tr>
                    <th width="30%" class="bg-light">ID</th>
                    <td>{{ $level->level_id }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Kode</th>
                    <td>{{ $level->level_kode }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Nama</th>
                    <td>{{ $level->level_nama }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-primary" data-dismiss="modal">
                <i class="fas fa-times me-1"></i> Tutup
            </button>
        </div>
    </div>
</div>
@endempty