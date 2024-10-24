@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/transaksi/import') }}')" class="btn btn-info">
                    <i class="fas fa-file-import"></i> Import
                </button>
                <a href="{{ url('/transaksi/export_excel') }}" class="btn btn-primary">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ url('/transaksi/export_pdf') }}" class="btn btn-warning">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <button onclick="modalAction('{{ url('/transaksi/create_ajax') }}')" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control form-control-sm" id="filter_date"
                                    name="filter_date">
                                <small class="form-text text-muted">Tanggal Transaksi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="table-transaksi">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Penjualan</th>
                            <th>Nama Pembeli</th>
                            <th>Tanggal Penjualan</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tableTransaksi;
        $(document).ready(function() {
            tableTransaksi = $('#table-transaksi').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    "url": "{{ url('transaksi/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.filter_date = $('#filter_date').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "penjualan_kode",
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pembeli",
                        className: "",
                        width: "20%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penjualan_tanggal",
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "user_nama",
                        className: "",
                        width: "15%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        width: "20%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#filter_date').on('change', function() {
                tableTransaksi.ajax.reload();
            });
        });
    </script>
@endpush
