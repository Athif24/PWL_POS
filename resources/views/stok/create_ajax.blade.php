<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Data Stok
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-building mr-1"></i>Nama Supplier
                            </label>
                            <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                                <option value="">- Pilih Supplier -</option>
                                @foreach ($supplier as $s)
                                    <option value="{{ $s->supplier_id }}">{{ $s->supplier_nama }}</option>
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
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
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
                                    <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-user_id" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal</label>
                            <input type="date" name="stok_tanggal" id="stok_tanggal"
                                class="form-control form-control-sm">
                            <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-sort-numeric-up mr-1"></i>Jumlah
                            </label>
                            <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" required>
                            <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary" id="btn-simpan">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
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
