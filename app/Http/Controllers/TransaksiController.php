<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Exception;

class TransaksiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi',
            'list' => ['Home', 'Transaksi']
        ];

        $page = (object) [
            'title' => 'Daftar transaksi penjualan dalam sistem',
        ];

        $activeMenu = 'transaksi';
        $user = UserModel::all();
        $barang = BarangModel::all();

        return view('transaksi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select(
            't_penjualan.penjualan_id',
            't_penjualan.penjualan_kode',
            't_penjualan.pembeli',
            't_penjualan.penjualan_tanggal',
            't_penjualan.user_id',
            'm_user.nama as user_nama',
            't_penjualan_detail.detail_id',
            't_penjualan_detail.harga',
            't_penjualan_detail.jumlah'
        )
            ->join('m_user', 't_penjualan.user_id', '=', 'm_user.user_id')
            ->join('t_penjualan_detail', 't_penjualan.penjualan_id', '=', 't_penjualan_detail.penjualan_id');

        if ($request->filter_date) {
            $penjualan->whereDate('penjualan_tanggal', $request->filter_date);
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($transaksi) {
                $btn = '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->penjualan_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->penjualan_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->penjualan_id . '/delete_ajax/' . $transaksi->detail_id) . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->editColumn('harga', function ($transaksi) {
                return 'Rp ' . number_format($transaksi->harga, 0, ',', '.');
            })
            ->editColumn('penjualan_tanggal', function ($transaksi) {
                return date('d/m/Y', strtotime($transaksi->penjualan_tanggal));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $user = UserModel::all();
        $barang = BarangModel::all();
        return view('transaksi.create_ajax', [
            'user' => $user,
            'barang' => $barang
        ]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi header transaksi
            $rules = [
                'penjualan_kode' => 'required|string|max:10|unique:t_penjualan,penjualan_kode',
                'pembeli' => 'required|string|max:100',
                'penjualan_tanggal' => 'required|date',
                'user_id' => 'required|integer',
            ];

            // Validasi items
            if (isset($request->items)) {
                foreach ($request->items as $key => $value) {
                    $rules["items.{$key}.barang_id"] = 'required|integer';
                    $rules["items.{$key}.jumlah"] = 'required|integer|min:1';
                    $rules["items.{$key}.harga"] = 'required|numeric|min:0';
                }
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            DB::beginTransaction();
            try {
                // Simpan header transaksi
                $penjualan = PenjualanModel::create([
                    'penjualan_kode' => $request->penjualan_kode,
                    'pembeli' => $request->pembeli,
                    'penjualan_tanggal' => $request->penjualan_tanggal,
                    'user_id' => $request->user_id
                ]);

                // Simpan detail transaksi
                foreach ($request->items as $item) {
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id' => $item['barang_id'],
                        'harga' => $item['harga'],
                        'jumlah' => $item['jumlah']
                    ]);
                }

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Data transaksi berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $transaksi = PenjualanModel::with(['user', 'penjualan_detail.barang'])
            ->find($id);
        return view('transaksi.show_ajax', ['transaksi' => $transaksi]);
    }

    public function edit_ajax(string $id)
    {
        $transaksi = PenjualanModel::with(['penjualan_detail'])->find($id);
        $user = UserModel::select('user_id', 'nama')->get();
        return view('transaksi.edit_ajax', [
            'transaksi' => $transaksi,
            'user' => $user
        ]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi hanya untuk field yang diedit
            $rules = [
                'penjualan_kode' => 'required|string|max:10|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
                'pembeli' => 'required|string|max:100',
                'penjualan_tanggal' => 'nullable|date',  // Ubah required menjadi nullable
                'user_id' => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            DB::beginTransaction();
            try {
                $penjualan = PenjualanModel::find($id);
                if (!$penjualan) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan'
                    ]);
                }

                // Update data header penjualan
                $updateData = [
                    'penjualan_kode' => $request->penjualan_kode,
                    'pembeli' => $request->pembeli,
                    'user_id' => $request->user_id
                ];

                // Hanya update tanggal jika diisi
                if ($request->filled('penjualan_tanggal')) {
                    $updateData['penjualan_tanggal'] = $request->penjualan_tanggal;
                }

                $penjualan->update($updateData);

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $penjualan_id, string $detail_id)
    {
        try {
            $transaksi = PenjualanModel::findOrFail($penjualan_id);
            $detail = PenjualanDetailModel::where('penjualan_id', $penjualan_id)
                ->where('detail_id', $detail_id)
                ->with('barang')
                ->firstOrFail();

            return view('transaksi.confirm_ajax', [
                'transaksi' => $transaksi,
                'detail' => $detail
            ]);
        } catch (\Exception $e) {
            return response()->view('transaksi.confirm_ajax', ['error' => true], 404);
        }
    }

    public function delete_ajax(Request $request, string $penjualan_id, string $detail_id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            DB::beginTransaction();
            try {
                // Cari detail penjualan yang akan dihapus
                $detail = PenjualanDetailModel::where('penjualan_id', $penjualan_id)
                    ->where('detail_id', $detail_id)
                    ->firstOrFail();

                // Hitung jumlah item yang tersisa
                $remainingItems = PenjualanDetailModel::where('penjualan_id', $penjualan_id)
                    ->where('detail_id', '!=', $detail_id)
                    ->count();

                // Hapus detail item
                $detail->delete();

                // Jika tidak ada item tersisa, hapus header penjualan
                if ($remainingItems === 0) {
                    PenjualanModel::findOrFail($penjualan_id)->delete();
                }

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ], 200);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }
        }

        // Jika bukan request AJAX, redirect
        return redirect('/transaksi')->with('error', 'Invalid request method');
    }

    public function import()
    {
        return view('transaksi.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_transaksi' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $file = $request->file('file_transaksi');
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                DB::beginTransaction();

                $currentPenjualan = null;
                $currentPenjualanId = null;

                if (count($data) > 1) {
                    foreach ($data as $row => $value) {
                        if ($row > 1) { // Skip header row
                            // Validasi data minimal yang diperlukan
                            if (
                                empty($value['A']) || empty($value['B']) || empty($value['C']) ||
                                empty($value['D']) || empty($value['E']) || empty($value['F']) ||
                                empty($value['G'])
                            ) {
                                continue;
                            }

                            // Jika kode penjualan berbeda dengan sebelumnya, buat transaksi baru
                            if ($currentPenjualan !== $value['A']) {
                                // Cek apakah kode penjualan sudah ada
                                $existingPenjualan = PenjualanModel::where('penjualan_kode', $value['A'])->first();
                                if ($existingPenjualan) {
                                    continue; // Skip jika sudah ada
                                }

                                // Convert date
                                try {
                                    $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $value['C'])->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $tanggal = now()->format('Y-m-d');
                                }

                                // Validasi user_id
                                $user_id = intval($value['D']);
                                $user = UserModel::find($user_id);
                                if (!$user) {
                                    continue;
                                }

                                // Create new penjualan header
                                $penjualan = PenjualanModel::create([
                                    'penjualan_kode' => $value['A'],    // Kode Penjualan
                                    'pembeli' => $value['B'],           // Nama Pembeli
                                    'penjualan_tanggal' => $tanggal,    // Tanggal Penjualan
                                    'user_id' => $user_id               // ID Petugas
                                ]);

                                $currentPenjualan = $value['A'];
                                $currentPenjualanId = $penjualan->penjualan_id;
                            }

                            // Cari barang berdasarkan nama
                            $barang = BarangModel::where('barang_nama', 'like', '%' . $value['E'] . '%')->first();
                            if (!$barang) {
                                continue; // Skip jika barang tidak ditemukan
                            }

                            // Create detail penjualan
                            PenjualanDetailModel::create([
                                'penjualan_id' => $currentPenjualanId,
                                'barang_id' => $barang->barang_id,
                                'harga' => floatval(str_replace(['Rp', '.', ','], '', $value['F'])), // Harga
                                'jumlah' => intval($value['G'])                                       // Jumlah
                            ]);
                        }
                    }

                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data transaksi berhasil diimport'
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        // Get transaction data with relationships
        $transaksi = PenjualanModel::with(['user', 'penjualan_detail.barang'])
            ->orderBy('penjualan_tanggal', 'desc')
            ->get();

        // Create new spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Transaksi');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Pembeli');
        $sheet->setCellValue('E1', 'Petugas');
        $sheet->setCellValue('F1', 'Barang');
        $sheet->setCellValue('G1', 'Harga');
        $sheet->setCellValue('H1', 'Jumlah');
        $sheet->setCellValue('I1', 'Total');

        // Style the header
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        $total = 0;

        foreach ($transaksi as $t) {
            // Pastikan penjualan_detail ada dan memiliki data
            if ($t->penjualan_detail->isNotEmpty()) {
                foreach ($t->penjualan_detail as $detail) {
                    $total_item = $detail->harga * $detail->jumlah;
                    $total += $total_item;

                    $sheet->setCellValue('A' . $baris, $no);
                    $sheet->setCellValue('B' . $baris, $t->penjualan_kode);
                    $sheet->setCellValue('C' . $baris, date('d/m/Y', strtotime($t->penjualan_tanggal)));
                    $sheet->setCellValue('D' . $baris, $t->pembeli);
                    $sheet->setCellValue('E' . $baris, $t->user->nama);
                    $sheet->setCellValue('F' . $baris, $detail->barang->barang_nama);
                    $sheet->setCellValue('G' . $baris, $detail->harga);
                    $sheet->setCellValue('H' . $baris, $detail->jumlah);
                    $sheet->setCellValue('I' . $baris, $total_item);

                    // Format currency columns
                    $sheet->getStyle('G' . $baris)->getNumberFormat()
                        ->setFormatCode('#,##0');
                    $sheet->getStyle('I' . $baris)->getNumberFormat()
                        ->setFormatCode('#,##0');

                    $baris++;
                    $no++;
                }
            }
        }

        // Add total row
        $sheet->setCellValue('H' . $baris, 'Total Penjualan:');
        $sheet->setCellValue('I' . $baris, $total);
        $sheet->getStyle('H' . $baris . ':I' . $baris)->getFont()->setBold(true);
        $sheet->getStyle('I' . $baris)->getNumberFormat()
            ->setFormatCode('#,##0');

        // Auto-size columns
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Transaksi');

        // Create Excel writer
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Transaksi ' . date('Y-m-d H:i:s') . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        // Get transaction data with relationships
        $transaksi = PenjualanModel::with(['user', 'penjualan_detail.barang'])
            ->orderBy('penjualan_tanggal', 'desc')
            ->get();

        // Calculate total with proper access to collection items
        $total = $transaksi->sum(function ($t) {
            return $t->penjualan_detail->sum(function ($detail) {
                return $detail->harga * $detail->jumlah;
            });
        });

        // Generate PDF
        $pdf = Pdf::loadView('transaksi.export_pdf', [
            'transaksi' => $transaksi,
            'total' => $total
        ]);

        // Configure PDF
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->setOption('margin-top', '10mm');
        $pdf->setOption('margin-right', '15mm');
        $pdf->setOption('margin-bottom', '10mm');
        $pdf->setOption('margin-left', '15mm');
        $pdf->render();

        // Stream PDF to browser
        return $pdf->stream('Data Transaksi ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
