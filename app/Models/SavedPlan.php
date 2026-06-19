<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedPlan extends Model
{
    protected $fillable = [
        'user_id',
        'destinasi_id',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }
}