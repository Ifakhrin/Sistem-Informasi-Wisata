<?php

namespace Database\Seeders;

use App\Models\TourismRating;
use Illuminate\Database\Seeder;

class TourismRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = storage_path('app/datasets/tourism_rating.csv');

        if (!file_exists($filePath)) {
            $this->command->error('File tourism_rating.csv tidak ditemukan di storage/app/datasets.');
            return;
        }

        TourismRating::query()->delete();

        $handle = fopen($filePath, 'r');

        $header = fgetcsv($handle);

        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            TourismRating::create([
                'user_dataset_id' => (int) $data['User_Id'],
                'place_id' => (int) $data['Place_Id'],
                'place_rating' => (int) $data['Place_Ratings'],
            ]);

            $imported++;
        }

        fclose($handle);

        $this->command->info("Berhasil import {$imported} data rating wisata.");
    }
}