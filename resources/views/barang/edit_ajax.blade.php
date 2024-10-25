@empty($barang)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
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
    <form action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-edit mr-2"></i>Edit Data Barang
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kategori Barang</label>
                        <div class="col-sm-9">
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">- Pilih Kategori -</option>
                                @foreach ($kategori as $k)
                                    <option {{ $k->kategori_id == $barang->kategori_id ? 'selected' : '' }}
                                        value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-kategori_id" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input value="{{ $barang->barang_kode }}" type="text" name="barang_kode" id="barang_kode"
                                class="form-control" required>
                            <small id="error-barang_kode" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input value="{{ $barang->barang_nama }}" type="text" name="barang_nama" id="barang_nama"
                                class="form-control" required>
                            <small id="error-barang_nama" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-9">
                            <input value="{{ $barang->harga_beli }}" type="number" name="harga_beli" id="harga_beli"
                                class="form-control" required>
                            <small id="error-harga_beli" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Harga Jual</label>
                        <div class="col-sm-9">
                            <input value="{{ $barang->harga_jual }}" type="number" name="harga_jual" id="harga_jual"
                                class="form-control" required>
                            <small id="error-harga_jual" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-warning mr-2" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
$(document).ready(function() {
    $("#form-edit").validate({
        rules: {
            kategori_id: {
                required: true,
                number: true
            },
            barang_kode: {
                required: true,
                maxlength: 10
            },
            barang_nama: {
                required: true,
                maxlength: 100
            },
            harga_beli: {
                required: true,
                number: true
            },
            harga_jual: {
                required: true,
                number: true
            }
        },
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
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-'+prefix).text(val[0]);
                        });
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
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
    </script>
@endempty
