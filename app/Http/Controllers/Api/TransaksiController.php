<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        return response()->json(PenjualanModel::all());
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'pembeli' => 'required|string|min:3|max:20',
            'penjualan_kode' => 'required|string|min:3|max:100|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'numeric',
            'harga' => 'required|array',
            'harga.*' => 'numeric',
            'jumlah' => 'required|array',
            'jumlah.*' => 'numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors()
            ]);
        }
        try {
            // Simpan data penjualan
            $penjualan = new PenjualanModel();
            $penjualan->user_id = $request->user_id;
            $penjualan->pembeli = $request->pembeli;
            $penjualan->penjualan_kode = $request->penjualan_kode;
            $penjualan->penjualan_tanggal = $request->penjualan_tanggal;
            $penjualan->save();
            // Simpan detail barang
            foreach ($request->barang_id as $index => $barangId) {
                $penjualan_detail = new PenjualanDetailModel();
                $penjualan_detail->penjualan_id = $penjualan->penjualan_id;
                $penjualan_detail->barang_id = $barangId;
                $penjualan_detail->harga = $request->harga[$index];
                $penjualan_detail->jumlah = $request->jumlah[$index];
                $penjualan_detail->save();
            }
            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan, data gagal disimpan!',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function show(string $id)
    {
        $penjualan = PenjualanModel::with(['penjualan_detail.barang'])->find($id);
        if ($penjualan) {
            return response()->json([
                'status' => true,
                'data' => $penjualan
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    public function update(Request $request, PenjualanModel $penjualan)
    {
        $penjualan->update($request->all());
        return response()->json($penjualan);
    }
    public function destroy(PenjualanModel $penjualan)
    {
        $penjualan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
