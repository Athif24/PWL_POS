<!--- Cek jika data tidak ditemukan --->
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
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <!--- Form untuk delete dengan AJAX --->
    <form action="{{ url('/transaksi/' . $transaksi->penjualan_id . '/delete_item/' . $detail->detail_id) }}" 
          method="POST" 
          id="form-delete-penjualan"
          class="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--- Alert konfirmasi --->
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data barang seperti di bawah ini?
                    </div>

                    <!--- Tabel detail data yang akan dihapus --->
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Kode Penjualan :</th>
                            <td class="col-9">{{ $transaksi->penjualan_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Pembeli :</th>
                            <td class="col-9">{{ $transaksi->pembeli }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal :</th>
                            <td class="col-9">{{ date('d/m/Y', strtotime($transaksi->penjualan_tanggal)) }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Barang :</th>
                            <td class="col-9">{{ $detail->barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Harga :</th>
                            <td class="col-9">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jumlah :</th>
                            <td class="col-9">{{ $detail->jumlah }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Total :</th>
                            <td class="col-9">Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <!--- Tombol aksi --->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus Data
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!--- Script untuk handling AJAX delete --->
    <script>
        $(document).ready(function() {
            // Setup CSRF token untuk semua request AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle form submission
            $("#form-delete-penjualan").on('submit', function(event) {
                event.preventDefault();
                var form = $(this);
                
                // Disable tombol submit untuk mencegah double submit
                form.find('button[type="submit"]').prop('disabled', true);

                // Tampilkan loading state
                Swal.fire({
                    title: 'Mohon Tunggu',
                    text: 'Sedang memproses...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading()
                    }
                });

                // Kirim request AJAX
                $.ajax({
                    url: form.attr('action'),
                    type: 'DELETE',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        // Tutup loading state
                        Swal.close();

                        if (response.status) {
                            // Tutup modal
                            $('#modal-master').closest('.modal').modal('hide');
                            
                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 2000
                            }).then(() => {
                                // Refresh DataTable jika ada
                                if ($.fn.DataTable.isDataTable('#dataPenjualan')) {
                                    $('#dataPenjualan').DataTable().ajax.reload(null, false);
                                } else {
                                    // Jika tidak ada DataTable, reload halaman
                                    window.location.reload();
                                }
                            });
                        } else {
                            // Tampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message,
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tutup loading state
                        Swal.close();
                        
                        // Log error untuk debugging
                        console.error('Error:', xhr.responseText);
                        
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menghapus data. Silakan coba lagi.',
                            showConfirmButton: true
                        });
                    },
                    complete: function() {
                        // Enable kembali tombol submit
                        form.find('button[type="submit"]').prop('disabled', false);
                    }
                });
            });

            // Handle modal close
            $('#modal-master').on('hidden.bs.modal', function() {
                // Bersihkan event handler untuk mencegah memory leak
                $("#form-delete-penjualan").off('submit');
            });
        });

        // Fungsi untuk refresh DataTable
        function refreshDataTable() {
            if ($.fn.DataTable.isDataTable('#dataPenjualan')) {
                $('#dataPenjualan').DataTable().ajax.reload(null, false);
            }
        }
    </script>
@endempty