<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beasiswa;

class HomeController extends Controller
{
    public function index()
    {
        $beasiswas = Beasiswa::where('status', 'aktif')
                            ->where('tanggal_tutup', '>=', now())
                            ->latest()
                            ->get();
                            
        return view('home', compact('beasiswas'));
    }
}