<form action="{{ url('/barang/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Data Barang
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Kategori Barang <span class="text-danger">*</span></label>
                            <select name="kategori_id" id="kategori_id" class="form-control select2" required>
                                <option value="">- Pilih Kategori -</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Kode <span class="text-danger">*</span></label>
                            <input type="text" name="barang_kode" id="barang_kode" class="form-control" placeholder="Masukkan kode barang" required>
                            <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="barang_nama" id="barang_nama" class="form-control" placeholder="Masukkan nama barang" required>
                            <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Harga Beli <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" name="harga_beli" id="harga_beli" class="form-control money" placeholder="0" required>
                            </div>
                            <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Harga Jual <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" name="harga_jual" id="harga_jual" class="form-control money" placeholder="0" required>
                            </div>
                            <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</form>
<script>
$(document).ready(function() {
    $("#form-tambah").validate({
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