<?php

namespace Database\Seeders;

use App\Models\Destinasi;
use Illuminate\Database\Seeder;

class DestinasiSeeder extends Seeder
{
    public function run(): void
    {
        $destinasis = [
            [
                'nama_wisata' => 'Pantai Kuta',
                'kategori' => 'Alam',
                'kota' => 'Badung',
                'provinsi' => 'Bali',
                'rating' => 4.6,
                'harga_tiket' => 10000,
                'latitude' => -8.7184,
                'longitude' => 115.1686,
                'deskripsi' => 'Pantai populer di Bali yang terkenal dengan pemandangan sunset dan aktivitas wisata pantai.',
                'gambar' => null,
            ],
            [
                'nama_wisata' => 'Candi Borobudur',
                'kategori' => 'Sejarah',
                'kota' => 'Magelang',
                'provinsi' => 'Jawa Tengah',
                'rating' => 4.8,
                'harga_tiket' => 50000,
                'latitude' => -7.6079,
                'longitude' => 110.2038,
                'deskripsi' => 'Candi Buddha terbesar di Indonesia yang menjadi destinasi wisata sejarah dan budaya.',
                'gambar' => null,
            ],
            [
                'nama_wisata' => 'Taman Mini Indonesia Indah',
                'kategori' => 'Budaya',
                'kota' => 'Jakarta Timur',
                'provinsi' => 'DKI Jakarta',
                'rating' => 4.5,
                'harga_tiket' => 25000,
                'latitude' => -6.3024,
                'longitude' => 106.8951,
                'deskripsi' => 'Tempat wisata budaya yang menampilkan keberagaman rumah adat dan budaya Indonesia.',
                'gambar' => null,
            ],
            [
                'nama_wisata' => 'Gunung Bromo',
                'kategori' => 'Alam',
                'kota' => 'Probolinggo',
                'provinsi' => 'Jawa Timur',
                'rating' => 4.9,
                'harga_tiket' => 35000,
                'latitude' => -7.9425,
                'longitude' => 112.9530,
                'deskripsi' => 'Destinasi wisata alam terkenal dengan pemandangan sunrise, lautan pasir, dan kawah gunung.',
                'gambar' => null,
            ],
            [
                'nama_wisata' => 'Masjid Istiqlal',
                'kategori' => 'Religi',
                'kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'rating' => 4.7,
                'harga_tiket' => 0,
                'latitude' => -6.1702,
                'longitude' => 106.8314,
                'deskripsi' => 'Masjid nasional Indonesia yang menjadi salah satu destinasi wisata religi di Jakarta.',
                'gambar' => null,
            ],
        ];

        foreach ($destinasis as $destinasi) {
            Destinasi::create($destinasi);
        }
    }
}