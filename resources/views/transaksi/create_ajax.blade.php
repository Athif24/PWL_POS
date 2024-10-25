<!-- Form Transaksi -->
<form action="{{ url('/transaksi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">
                    <i class="fas fa-cart-plus mr-2"></i>Tambah Data Transaksi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Data Transaksi -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Petugas Transaksi</label>
                            <select name="user_id" id="user_id" class="form-control form-control-sm">
                                <option value="">- Pilih Petugas -</option>
                                @foreach ($user as $u)
                                    <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-user_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Kode</label>
                            <input type="text" name="penjualan_kode" id="penjualan_kode"
                                class="form-control form-control-sm">
                            <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Pembeli</label>
                            <input type="text" name="pembeli" id="pembeli" class="form-control form-control-sm">
                            <small id="error-pembeli" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Penjualan</label>
                            <input type="date" name="penjualan_tanggal" id="penjualan_tanggal"
                                class="form-control form-control-sm">
                            <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <!-- Detail Barang -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 font-weight-bold text-primary">
                                <i class="fas fa-box mr-2"></i>Detail Barang
                            </h6>
                            <button type="button" class="btn btn-primary btn-sm" id="btn-add-item">
                                Tambah
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-top-0 px-3">Barang</th>
                                        <th class="border-top-0" style="width: 20%;">Harga</th>
                                        <th class="border-top-0" style="width: 15%;">Jumlah</th>
                                        <th class="border-top-0" style="width: 20%;">Subtotal</th>
                                        <th class="border-top-0 text-center" style="width: 70px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="item-container">
                                    <!-- Items will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Template item barang (hidden) -->
                <template id="item-template">
                    <tr class="item-row">
                        <td class="px-3">
                            <select name="items[0][barang_id]" class="form-control form-control-sm barang-select">
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                                        {{ $b->barang_nama }}</option>
                                @endforeach
                            </select>
                            <small class="error-text form-text text-danger"></small>
                        </td>
                        <td>
                            <input type="number" name="items[0][harga]"
                                class="form-control form-control-sm harga-input" readonly>
                            <small class="error-text form-text text-danger"></small>
                        </td>
                        <td>
                            <input type="number" name="items[0][jumlah]"
                                class="form-control form-control-sm jumlah-input" min="1">
                            <small class="error-text form-text text-danger"></small>
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm subtotal-input" readonly>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-item">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </template>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="mb-0 font-weight-bold text-primary">Total: <span id="total-amount">Rp 0</span></h5>
                    <div>
                        <button type="button" data-dismiss="modal" class="btn btn-warning btn-sm px-4 mr-2">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        let itemCount = 0;

        // Fungsi untuk memformat angka ke format rupiah
        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }

        // Fungsi untuk menghitung subtotal
        function calculateSubtotal(row) {
            const harga = parseFloat(row.find('.harga-input').val()) || 0;
            const jumlah = parseFloat(row.find('.jumlah-input').val()) || 0;
            const subtotal = harga * jumlah;
            row.find('.subtotal-input').val(subtotal);
            return subtotal;
        }

        // Fungsi untuk menghitung total keseluruhan
        function calculateTotal() {
            let total = 0;
            $('.item-row').each(function() {
                total += calculateSubtotal($(this));
            });
            $('#total-amount').text(formatRupiah(total));
        }

        // Event handler untuk tombol tambah barang
        $('#btn-add-item').click(function() {
            itemCount++;
            const template = document.getElementById('item-template').content.cloneNode(true);

            // Update name attributes
            $(template).find('select, input').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    $(this).attr('name', name.replace('[0]', `[${itemCount-1}]`));
                }
            });

            $('#item-container').append(template);

            // Reinitialize event handlers for new elements
            initializeItemHandlers($('#item-container .item-row').last());
        });

        // Fungsi untuk menginisialisasi event handlers pada item row
        function initializeItemHandlers(row) {
            // Handler untuk pemilihan barang
            row.find('.barang-select').change(function() {
                const harga = $(this).find(':selected').data('harga') || 0;
                row.find('.harga-input').val(harga);
                calculateSubtotal(row);
                calculateTotal();
            });

            // Handler untuk input jumlah
            row.find('.jumlah-input').on('input', function() {
                calculateSubtotal(row);
                calculateTotal();
            });

            // Handler untuk tombol hapus
            row.find('.btn-remove-item').click(function() {
                row.remove();
                calculateTotal();
            });
        }

        // Inisialisasi validasi form
        $("#form-tambah").validate({
            rules: {
                user_id: {
                    required: true,
                    number: true
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
                    required: true,
                    date: true
                }
            },
            submitHandler: function(form) {
                // Validasi minimal satu item
                if ($('.item-row').length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Minimal harus ada satu barang'
                    });
                    return false;
                }

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

        // Tambahkan item pertama secara otomatis
        $('#btn-add-item').click();
    });
</script>
