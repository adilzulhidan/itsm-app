<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NetworkMonitorController extends Controller
{
    public function index()
    {
        // Nanti Anda bisa mengambil data real dari database di sini
        // Contoh: $serverStatus = Server::all();
        
        return view('monitor.index');
    }
}
