<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Illuminate\Support\Facades\File;
use  Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $home_slider = DB::table('home_slider')->where('status',1)->get();
        $kategori = DB::table('kategori_produk')->get();
        return view('home',compact('home_slider','kategori'));
    }
}
