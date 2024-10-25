@empty($barang)
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
        <div class="modal-body">
            <div class="alert alert-danger mb-4">
                <h5><i class="icon fas fa-ban mr-2"></i>Kesalahan!</h5>
                <p class="mb-0">Data yang anda cari tidak ditemukan</p>
            </div>
            <a href="{{ url('/barang') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@else
    <form action="{{ url('/barang/' . $barang->barang_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-trash-alt mr-2"></i>Hapus Data Barang
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-4">
                        <h5><i class="icon fas fa-exclamation-triangle mr-2"></i>Konfirmasi!</h5>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus data berikut?</p>
                    </div>
                    <table class="table table-bordered table-striped mb-4">
                        <tr>
                            <th class="text-right bg-light col-4">Kategori Barang</th>
                            <td class="col-8">{{ $barang->kategori->kategori_nama }}</td>
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
                    </table>
                    <div class="text-right">
                        <button type="button" class="btn btn-warning mr-2" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt mr-2"></i> Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
$(document).ready(function() {
    $("#form-delete").validate({
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then((result) => {
                            // Reload halaman setelah SweetAlert ditutup
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server'
                    });
                }
            });
            return false;
        }
    });
});
    </script>
@endempty