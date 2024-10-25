@empty($transaksi)
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
            <div class="modal-body text-center py-5">
                <div class="alert alert-danger d-inline-block">
                    <h5><i class="icon fas fa-ban mr-2"></i>Data tidak ditemukan</h5>
                </div>
                <div class="mt-4">
                    <a href="{{ url('/transaksi') }}" class="btn btn-warning">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/transaksi/' . $transaksi->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-edit mr-2"></i>Edit Data Transaksi
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-user mr-2"></i>Petugas Transaksi
                                </label>
                                <select name="user_id" id="user_id" class="form-control select2" required>
                                    <option value="">- Pilih Petugas -</option>
                                    @foreach ($user as $k)
                                        <option value="{{ $k->user_id }}"
                                            {{ $k->user_id == $transaksi->user_id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <small id="error-user_id" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-barcode mr-2"></i>Kode Penjualan
                                </label>
                                <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control"
                                    value="{{ $transaksi->penjualan_kode }}" required>
                                <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-user-tag mr-2"></i>Pembeli
                                </label>
                                <input type="text" name="pembeli" id="pembeli" class="form-control"
                                    value="{{ $transaksi->pembeli }}" required>
                                <small id="error-pembeli" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="form-group mb-0">
                                <label class="font-weight-bold">
                                    <i class="fas fa-calendar-alt mr-2"></i>Tanggal Penjualan
                                </label>
                                <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control"
                                    value="{{ $transaksi->penjualan_tanggal }}">
                                <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                            </div>
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
                    user_id: {
                        required: true
                    },
                    penjualan_kode: {
                        required: true,
                        maxlength: 10
                    },
                    pembeli: {
                        required: true,
                        maxlength: 100
                    },
                    penjualan_tanggal: {
                        date: true
                    }
                },
                messages: {
                    user_id: {
                        required: "Petugas harus dipilih"
                    },
                    penjualan_kode: {
                        required: "Kode penjualan harus diisi",
                        maxlength: "Kode penjualan maksimal 10 karakter"
                    },
                    pembeli: {
                        required: "Nama pembeli harus diisi",
                        maxlength: "Nama pembeli maksimal 100 karakter"
                    },
                    penjualan_tanggal: {
                        date: "Format tanggal tidak valid"
                    }
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
                                }).then((result) => {
                                    // Reload tabel setelah sukses
                                    if (typeof tableTransaksi !== 'undefined') {
                                        tableTransaksi.ajax.reload();
                                    }
                                });
                            } else {
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal menghubungi server'
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
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
