<?php

namespace Database\Seeders;

use App\Models\Destinasi;
use App\Models\SavedPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourismDatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = storage_path('app/datasets/tourism_with_id.csv');

        if (!file_exists($filePath)) {
            $this->command->error('File tourism_with_id.csv tidak ditemukan di storage/app/datasets.');
            return;
        }

        $provinceMap = [
            'Jakarta' => 'DKI Jakarta',
            'Yogyakarta' => 'DI Yogyakarta',
            'Bandung' => 'Jawa Barat',
            'Semarang' => 'Jawa Tengah',
            'Surabaya' => 'Jawa Timur',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        SavedPlan::query()->delete();
        Destinasi::query()->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $handle = fopen($filePath, 'r');

        $header = fgetcsv($handle);

        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            $city = $data['City'] ?? null;

            Destinasi::create([
                'place_id' => (int) $data['Place_Id'],
                'nama_wisata' => $data['Place_Name'],
                'kategori' => $data['Category'],
                'kota' => $city,
                'provinsi' => $provinceMap[$city] ?? $city,
                'rating' => (float) $data['Rating'],
                'harga_tiket' => (int) $data['Price'],
                'time_minutes' => $data['Time_Minutes'] !== '' ? (int) $data['Time_Minutes'] : null,
                'latitude' => $data['Lat'] !== '' ? $data['Lat'] : null,
                'longitude' => $data['Long'] !== '' ? $data['Long'] : null,
                'deskripsi' => $data['Description'],
                'gambar' => null,
            ]);

            $imported++;
        }

        fclose($handle);

        $this->command->info("Berhasil import {$imported} data destinasi wisata.");
    }
}