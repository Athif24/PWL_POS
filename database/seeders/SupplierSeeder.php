<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
              'supplier_id' => 1,
              'supplier_kode' => 'SP1',
              'supplier_nama' => 'PT Mitra Sejahtera Abadi',
              'supplier_alamat' => 'Jl. Gatot Subroto No.12, Jakarta Selatan',  
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'SP2',
                'supplier_nama' => 'PT Sumber Mulia Indah',
                'supplier_alamat' => 'Jl. Cisitu No.15, Jakarta Pusat',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SP3',
                'supplier_nama' => 'PT Artha Graha Mitra',
                'supplier_alamat' => 'Jl. Raya Jakarta No.10, Jakarta Timur',
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
