@empty($transaksi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/transaksi/' . $transaksi->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Informasi Transaksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Petugas Transaksi</label>
                                <select name="user_id" id="user_id" class="form-control" required>
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
                                <label>Kode Penjualan</label>
                                <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control"
                                    value="{{ $transaksi->penjualan_kode }}" required>
                                <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Pembeli</label>
                                <input type="text" name="pembeli" id="pembeli" class="form-control"
                                    value="{{ $transaksi->pembeli }}" required>
                                <small id="error-pembeli" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Penjualan</label>
                                <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control"
                                    value="{{ $transaksi->penjualan_tanggal }}">
                                <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                                    if(typeof tableTransaksi !== 'undefined') {
                                        tableTransaksi.ajax.reload();
                                    }
                                });
                            } else {
                                $('.error-text').text('');
                                if(response.msgField) {
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