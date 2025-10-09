<?php

namespace App\Http\Controllers;

use App\Models\Vuelo;

class VueloController extends Controller
{
    public function index()
    {
        $vuelos = Vuelo::all();
        return view('vuelos.index', compact('vuelos'));
    }
}
