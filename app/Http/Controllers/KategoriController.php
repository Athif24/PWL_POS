<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem',
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif
        $kategori = KategoriModel::all(); // ambil data level untuk filter level

        return view('kategori.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'kategori' => $kategori,'activeMenu'=>$activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datables
    public function list(Request $request)
    {
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama')
            ->with('kategori');

        // Filter data user berdasarkan level_id
        if ($request->kategori_id) {
            $kategoris->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategoris)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id. '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/'.$kategori->kategori_id).'">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return
                confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Form Tambah Ktegori',
        ];

        $kategori = KategoriModel::all(); // Ambil data level untuk ditampilkan di form
        $activeMenu = 'kategori'; // Set menu yang sedang aktif

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data user baru
    public function store(Request $request) {
        $request->validate([
            //kategori_kode harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_kategori kolom kategori_kode
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100' //kategori_nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request -> kategori_nama,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect('/kategori') -> with('success', 'Data kategori berhasil disimpan');
    }

    // Menampilkan halaman detail user
    public function show(String $id){
        $kategori = KategoriModel::with('kategori') -> find($id);
        $breadcrumb = (object)[
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail kategori'
        ];
        $activeMenu = 'kategori'; //set menu yang sedang aktif
        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page'=>$page, 'kategori'=>$kategori, 'activeMenu'=>$activeMenu]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id){
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object)[
            'title' => 'Edit kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'kategori';
        return view ('kategori.edit', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'kategori'=>$kategori, 'activeMenu'=>$activeMenu]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100'
        ]);

        $kategori = KategoriModel::find($id);
        
        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
            'kategori_id' => $request->kategori_id
        ]);
        return redirect('/kategori')->with('success' . "data kategori berhasil diubah");
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        // Cek apakah data user dengan ID yang dimaksud ada atau tidak
        $check = KategoriModel::find($id);
        
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data user tidak ditemukan');
        }

        try {
            // Hapus data user
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
