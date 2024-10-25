@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white"><i class="fas fa-exclamation-circle mr-2"></i>Kesalahan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger border-0 shadow-sm">
                    <h5><i class="icon fas fa-ban mr-2"></i>Data Tidak Ditemukan!</h5>
                    <p class="mb-0">Data yang anda cari tidak tersedia dalam database.</p>
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><i class="fas fa-info-circle mr-2"></i>Detail User</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th class="text-right bg-light" width="30%">ID</th>
                        <td>{{ $user->user_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right bg-light">Level</th>
                        <td>{{ $user->level->level_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right bg-light">Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th class="text-right bg-light">Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right bg-light">Password</th>
                        <td><code>{{ $user->password }}</code></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-times mr-2"></i> Tutup</button>
            </div>
        </div>
    </div>
@endempty