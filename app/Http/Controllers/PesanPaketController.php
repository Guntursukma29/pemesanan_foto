<?php

namespace App\Http\Controllers;

use App\Models\Fotografi;
use App\Models\Videografi;
use Illuminate\Http\Request;

class PesanPaketController extends Controller
{
    public function index(){
        
        $data = Fotografi::all();
        $videografis = Videografi::all();
        return view('paket', compact('data', 'videografis'));
    }
     
}
