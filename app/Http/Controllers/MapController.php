<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;

class MapController extends Controller
{
    public function index()
    {
        $destinasis = Destinasi::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('map.index', compact('destinasis'));
    }
}