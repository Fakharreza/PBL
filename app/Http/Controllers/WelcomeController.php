<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\infoPelatihanModel;
use App\Models\infoSertifikasiModel;

class WelcomeController extends Controller{
    public function index() {
        
        $breadcrumb = (object) [
            'title' => 'Beranda',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}