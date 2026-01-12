<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    public function index()
    {
        
        $categories = [
            ['name' => 'Hardware', 'icon' => 'monitor', 'count' => 12, 'color' => 'text-blue-500', 'border' => 'border-t-blue-500'],
            ['name' => 'Software', 'icon' => 'window', 'count' => 24, 'color' => 'text-green-500', 'border' => 'border-t-green-500'],
            ['name' => 'Network', 'icon' => 'wifi', 'count' => 8, 'color' => 'text-orange-500', 'border' => 'border-t-orange-500'],
            ['name' => 'Security', 'icon' => 'lock', 'count' => 5, 'color' => 'text-purple-500', 'border' => 'border-t-purple-500'],
        ];

        
        $articles = [
            ['title' => 'Cara reset password email', 'views' => '1.2k', 'date' => '2 hari lalu'],
            ['title' => 'Panduan koneksi VPN (Waringin)', 'views' => '850', 'date' => '1 minggu lalu'],
            ['title' => 'Mengatasi printer Offline', 'views' => '540', 'date' => '3 bulan lalu'],
        ];

        return view('knowledgebase.index', compact('categories', 'articles'));
    }
}