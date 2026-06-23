<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Kerusakan Jaringan',
            'Kerusakan Fisik Komputer',
            'Software Error',
            'Printer / Scanner',
            'Server',
            'Email / Office 365',
            'Lainnya',
        ];

        foreach ($kategoris as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}