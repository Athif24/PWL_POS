@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger mb-4">
                    <h5 class="mb-0"><i class="icon fas fa-ban mr-2"></i>Data yang anda cari tidak ditemukan</h5>
                </div>
                <div class="text-right">
                    <a href="{{ url('/stok') }}" class="btn btn-warning px-4">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-trash-alt mr-2"></i>Hapus Data Stok
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning mb-4">
                        <h5 class="mb-0">
                            <i class="icon fas fa-exclamation-triangle mr-2"></i>Konfirmasi
                        </h5>
                        <p class="mb-0 mt-2">Apakah Anda ingin menghapus data seperti di bawah ini?</p>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th class="bg-light text-right width-30">Nama Supplier</th>
                                    <td>{{ $stok->supplier->supplier_nama }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-right">Nama Barang</th>
                                    <td>{{ $stok->barang->barang_nama }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-right">Penginput</th>
                                    <td>{{ $stok->user->nama }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-right">Tanggal</th>
                                    <td>{{ $stok->stok_tanggal }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-right">Jumlah</th>
                                    <td>{{ $stok->stok_jumlah }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-warning px-4" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash-alt mr-2"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
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
                                dataStok.ajax.reload();
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