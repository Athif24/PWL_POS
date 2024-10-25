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
    <form action="{{ url('/supplier/' .$supplier->supplier_id. '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                        <i class="fas fa-edit mr-2"></i>Edit Data Supplier
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><i class="fas fa-barcode mr-2"></i>Kode Supplier</label>
                        <input value="{{ $supplier->supplier_kode }}" type="text" name="supplier_kode" id="supplier_kode"
                            class="form-control" required placeholder="Masukkan kode supplier">
                        <small id="error-supplier_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-building mr-2"></i>Nama Supplier</label>
                        <input value="{{ $supplier->supplier_nama }}" type="text" name="supplier_nama" id="supplier_nama" 
                            class="form-control" required placeholder="Masukkan nama supplier">
                        <small id="error-supplier_nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt mr-2"></i>Alamat</label>
                        <input value="{{ $supplier->supplier_alamat }}" type="text" name="supplier_alamat" id="supplier_alamat" 
                            class="form-control" required placeholder="Masukkan alamat supplier">
                        <small id="error-supplier_alamat" class="error-text form-text text-danger"></small>
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
                    supplier_kode: {
                    required: true,
                    maxlength: 10
                },
                supplier_nama: {
                    required: true,
                    maxlength: 100
                },
                supplier_alamat: {
                    required: true,
                    maxlength: 225
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
                                dataSupplier.ajax.reload();
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
