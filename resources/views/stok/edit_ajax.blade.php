@empty($stok)
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
        <div class="modal-body text-center py-4">
            <div class="alert alert-danger d-inline-block">
                <h5 class="mb-0"><i class="icon fas fa-ban mr-2"></i>Data yang anda cari tidak ditemukan</h5>
            </div>
            <div class="mt-4">
                <a href="{{ url('/stok') }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-edit mr-2"></i>Edit Data Stok
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            <i class="fas fa-building mr-1"></i>Nama Supplier
                        </label>
                        <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                            <option value="">- Pilih Supplier -</option>
                            @foreach ($supplier as $s)
                                <option {{ $s->supplier_id == $stok->supplier_id ? 'selected' : '' }} 
                                    value="{{ $s->supplier_id }}">{{ $s->supplier_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">
                            <i class="fas fa-box mr-1"></i>Nama Barang
                        </label>
                        <select name="barang_id" id="barang_id" class="form-control select2" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach ($barang as $b)
                                <option {{ $b->barang_id == $stok->barang_id ? 'selected' : '' }}
                                    value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-barang_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">
                            <i class="fas fa-user mr-1"></i>Penginput
                        </label>
                        <select name="user_id" id="user_id" class="form-control select2" required>
                            <option value="">- Pilih Penginput -</option>
                            @foreach ($user as $u)
                                <option {{ $u->user_id == $stok->user_id ? 'selected' : '' }}
                                    value="{{ $u->user_id }}">{{ $u->nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-user_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">
                            <i class="fas fa-calendar mr-1"></i>Tanggal
                        </label>
                        <input value="{{ $stok->stok_tanggal }}" type="text" name="stok_tanggal" 
                            id="stok_tanggal" class="form-control datepicker" required>
                        <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">
                            <i class="fas fa-cubes mr-1"></i>Jumlah
                        </label>
                        <input value="{{ $stok->stok_jumlah }}" type="number" name="stok_jumlah" 
                            id="stok_jumlah" class="form-control" required>
                        <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
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
                    supplier_id: {
                        required: true,
                        number: true
                    },
                    barang_id: {
                        required: true,
                        number: true
                    },
                    user_id: {
                        required: true,
                        number: true
                    },
                    stok_tanggal: {
                        required: true,
                        date: true
                    },
                    stok_jumlah: {
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