<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $title = "Halaman home";
        $content ['mahasiswa'] = array(
            'nama' => 'Kadek Satria Kurniawan',
            'nim' => '1915101058'
        );

        return view('admin/beranda', compact('title', 'content'));
    }
}
