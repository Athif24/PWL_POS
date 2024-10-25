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
    <form action="{{ url('/kategori/' .$kategori->kategori_id. '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                        <i class="fas fa-edit mr-2"></i>Edit Data Kategori
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-right">Kode <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input value="{{ $kategori->kategori_kode }}" type="text" name="kategori_kode" 
                                id="kategori_kode" class="form-control" required>
                            <small id="error-kategori_kode" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-right">Nama <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input value="{{ $kategori->kategori_nama }}" type="text" name="kategori_nama" 
                                id="kategori_nama" class="form-control" required>
                            <small id="error-kategori_nama" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    kategori_kode: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    kategori_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataKategori.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
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
