<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'MK1',
                'barang_nama' => 'Mie Ayam',
                'harga_beli' => 8000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'MK2',
                'barang_nama' => 'Nasi Goreng',
                'harga_beli' => '10000',
                'harga_jual' => '12000',
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 1,
                'barang_kode' => 'MK3',
                'barang_nama' => 'Rendang',
                'harga_beli' => '12000',
                'harga_jual' => '15000',
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'PW1',
                'barang_nama' => 'Pelembab Wajah',
                'harga_beli' => '50000',
                'harga_jual' => '75000',
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 2,
                'barang_kode' => 'PW2',
                'barang_nama' => 'Sunscreen SPF',
                'harga_beli' => '80000',
                'harga_jual' => '120000',
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 2,
                'barang_kode' => 'PW3',
                'barang_nama' => 'Sabun Pembersih Wajah',
                'harga_beli' => '40000',
                'harga_jual' => '60000',
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 3,
                'barang_kode' => 'PR1',
                'barang_nama' => 'Pembersih Lantai',
                'harga_beli' => '15000',
                'harga_jual' => '20000',
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 3,
                'barang_kode' => 'PR2',
                'barang_nama' => 'Pewangi Pakaian',
                'harga_beli' => '12000',
                'harga_jual' => '16000',
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 3,
                'barang_kode' => 'PR3',
                'barang_nama' => 'Pembersih Kaca',
                'harga_beli' => '10000',
                'harga_jual' => '15000',
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 4,
                'barang_kode' => 'PB1',
                'barang_nama' => 'Botol Susu Bayi',
                'harga_beli' => '30000',
                'harga_jual' => '45000',
            ],
            [
                'barang_id' => 11,
                'kategori_id' => 4,
                'barang_kode' => 'PB2',
                'barang_nama' => 'Baju Bayi',
                'harga_beli' => '40000',
                'harga_jual' => '55000',
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 4,
                'barang_kode' => 'PB3',
                'barang_nama' => 'Selimut Bayi',
                'harga_beli' => '75000',
                'harga_jual' => '100000',
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 5,
                'barang_kode' => 'EL1',
                'barang_nama' => 'Smartphone',
                'harga_beli' => '3000000',
                'harga_jual' => '3500000',
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 5,
                'barang_kode' => 'EL2',
                'barang_nama' => 'Kamera Digital',
                'harga_beli' => '5000000',
                'harga_jual' => '6500000',
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 5,
                'barang_kode' => 'EL3',
                'barang_nama' => 'Smart TV',
                'harga_beli' => '4000000',
                'harga_jual' => '4500000',
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
