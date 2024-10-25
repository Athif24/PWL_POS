@empty($barang)
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="alert alert-danger mb-4">
                    <h5><i class="icon fas fa-ban mr-2"></i>Data tidak ditemukan!</h5>
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning px-4">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-2"></i>Detail Barang
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th class="text-right bg-light" width="30%">ID</th>
                            <td>{{ $barang->barang_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right bg-light">Kategori</th>
                            <td>{{ $barang->kategori->kategori_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right bg-light">Kode</th>
                            <td>{{ $barang->barang_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right bg-light">Nama</th>
                            <td>{{ $barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right bg-light">Harga Beli</th>
                            <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right bg-light">Harga Jual</th>
                            <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-primary px-4" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
            </div>
        </div>
    </div>
@endempty