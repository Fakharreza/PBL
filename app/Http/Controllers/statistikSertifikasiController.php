<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class statistikSertifikasiController extends Controller
{
    public function index() {
        
        $breadcrumb = (object) [
            'title' => 'Statistik',
            'list' => ['Home', 'Statistik Sertifikasi']
        ];

        $activeMenu = 'dashboard';

        return view('statistikSertifikasi', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
