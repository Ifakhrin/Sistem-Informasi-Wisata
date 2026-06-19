<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    protected $fillable = [
        'place_id',
        'nama_wisata',
        'kategori',
        'kota',
        'provinsi',
        'rating',
        'harga_tiket',
        'time_minutes',
        'latitude',
        'longitude',
        'deskripsi',
        'gambar',
    ];
}