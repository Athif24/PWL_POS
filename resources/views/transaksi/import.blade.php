<form action="{{ url('/transaksi/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-file-import mr-2"></i>Import Data Transaksi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body p-4">
                <div class="form-group mb-4">
                    <label class="font-weight-bold mb-2">Template Excel</label>
                    <div>
                    <a href="{{ asset('template_transaksi.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download Template
                    </a>
                </div>
                <small id="error-transaksi_id" class="error-text form-text text-danger"></small>
            </div>

            <div class="form-group">
                <label class="font-weight-bold mb-2">Upload File Excel</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file_transaksi" name="file_transaksi" required>
                    <label class="custom-file-label" for="file_transaksi">Pilih file...</label>
                </div>
                <small class="form-text text-muted">Format yang didukung: .xlsx</small>
                <small id="error-file_transaksi" class="error-text form-text text-danger"></small>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-warning" data-dismiss="modal">
                <i class="fas fa-times mr-2"></i>Batal
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload mr-2"></i>Upload
            </button>
        </div>
    </div>
</div>
</form>

<script>
$(document).ready(function() {
    $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    $("#form-import").validate({
        rules: {
            file_transaksi: {
                required: true,
                extension: "xlsx"
            },
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        tableTransaksi.ajax.reload();
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